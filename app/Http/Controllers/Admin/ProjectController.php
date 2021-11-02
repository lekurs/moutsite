<?php


namespace App\Http\Controllers\Admin;


use App\Models\Client;
use App\Models\Project;
use App\Repository\ClientRepository;
use App\Repository\MediaProjectRepository;
use App\Repository\ProjectRepository;
use App\Repository\ServiceRepository;
use App\Repository\SkillRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditProject;
use App\Http\Requests\StoreProject;
use App\Services\Uploads\UploadedFilesService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * ProjectController constructor.
     * @param ProjectRepository $projectRepository
     * @param UploadedFilesService $uploadedFilesService
     * @param ClientRepository $clientRepository
     * @param SkillRepository $skillRepository
     * @param MediaProjectRepository $mediaProjectRepository
     * @param ServiceRepository $serviceRepository
     */
    public function __construct(
        private ProjectRepository $projectRepository,
        private UploadedFilesService $uploadedFilesService,
        private ClientRepository $clientRepository,
        private SkillRepository $skillRepository,
        private MediaProjectRepository $mediaProjectRepository,
        private ServiceRepository $serviceRepository
    ) { }


    public function index(): View
    {
        $projects = $this->projectRepository->getAllBy12();
        $clients = $this->clientRepository->getAll();
        $services = $this->serviceRepository->getAll();
        $skills = $this->skillRepository->getAll();

        return \view('pages.admin.projects.index', [
            'projects' => $projects,
            'clients' => $clients,
            'services' => $services,
            'skills' => $skills
        ]);
    }

    public function create(): View
    {
        $skills = $this->skillRepository->getAll();
        $clients = Client::with('users')->get();

        return \view('pages.admin.projects.create', [
            'clients' => $clients,
            'skills' => $skills
        ]);
    }

    public function store(StoreProject $storeProject)
    {
        $client = $this->clientRepository->getOneById($storeProject['client-id']);

        $this->projectRepository->store($storeProject->all());

//        if(isset($storeProject['image']) && !is_null($storeProject['image'])) {
//            foreach($storeProject['image'] as $uploadedImg) {
//                $this->uploadedFilesService->moveFile($uploadedImg, '/public/images/uploads/' . $client->slug . '/projets/' . Str::slug($storeProject['project-title']));
//            }
//        }

//        if(isset($storeProject['project-img-portfolio']) && !is_null($storeProject['project-img-portfolio'])) {
//            $this->uploadedFilesService->moveFile($storeProject['project-img-portfolio'], '/public/images/uploads/' . $client->slug . '/projets/portfolio');
//        }

//        if(isset($storeProject['project-background-img']) && !is_null($storeProject['project-background-img'])) {
//            $this->uploadedFilesService->moveFile($storeProject['project-background-img'], '/public/images/uploads/' . $client->slug . '/projets/portfolio');
//        }

        return redirect()->route('clients.show', $client->slug)->with('success', 'Projet ajouté');
    }

    public function edit(Project $project)
    {
        $oneProject = $this->projectRepository->getOneBySLugWithMediasOrderByDisplay($project->slug);
        $skills = $this->skillRepository->getAll();

        $projectSkills = [];

        foreach($oneProject->skills as $skillProject)
        {
            $projectSkills[] = $skillProject->skill;
        }

        return view('pages.admin.projects.show', [
            'project' => $project,
            'skills' => $skills,
            'projectSkills' => $projectSkills
        ]);
    }

    public function update(EditProject $data): RedirectResponse
    {
        $this->projectRepository->editStore($data->all());

        $project = $this->projectRepository->getOneBySlug(Str::slug($data['project-title']));

        //TODO => Utiliser les events Laravel

        if(isset($data['img-project-portfolio'])) {
            $this->uploadedFilesService->moveFile($data['img-project-portfolio'], '/public/images/uploads/' . $project->client->slug . '/projets/portfolio');
        }

        if (isset($data['project-background-img'])) {
            $this->uploadedFilesService->moveFile($data['project-background-img'], '/public/images/uploads/' . $project->client->slug . '/projets/portfolio');
        }
        //TODO => mettre à jour les compétences et le chemin des images si modifiées !!

        return redirect()->route('clients.show', $project->client->slug)->with('success', 'Projet mis à jour');
    }

    public function destroy(Project $project)
    {
        $this->projectRepository->delete($project->slug);

        return back()->with('success', 'Projet supprimé');
    }

    public function search()
    {
        $projects = $this->projectRepository->getAllWithSearchBar(request('project-name'), request('skill'));

        $clients = $this->clientRepository->getAll();
        $services = $this->serviceRepository->getAll();
        $skills = $this->skillRepository->getAll();

        return view('pages.admin.projects.index', [
            'projects' => $projects,
            'clients' => $clients,
            'services' => $services,
            'skills' => $skills
        ]);
    }

    public function updateMedia()
    {
        $project = Project::whereId(request('project-media-img-id'))->first();
        $client = Client::whereId($project->client_id)->first();
        $file = request('add-project-media-input');
        $medias = $this->mediaProjectRepository->getAllMediasByProject($project);
        $position = request('project-media-position-input');

        $this->mediaProjectRepository->removeMediaOrder($project);

        $mediaOrder = [];

        foreach ($medias as $media) {
            $mediaOrder[] = $media['mediaProjectPath'];
        }

        $this->addinarray($mediaOrder, request('media-project-order-new-img'), $file->getClientOriginalName(), $position);

        $this->mediaProjectRepository->storeAndReorganizeOrder($project, $file, $mediaOrder);

        //TODO => Utiliser event() de Laravel
        $this->uploadedFilesService->moveFile($file, '/public/images/uploads/' . $client->slug . '/projets/' . Str::slug($project->title));

        $jsonResponse = [
            'response' => 'success',
            'url_img' =>  '/storage/images/uploads/' . $project->client->slug . '/projets/' . $project->slug . '/' . $file->getClientOriginalName(),
        ];

        return response()->json($jsonResponse);
    }

    public function destroyMedia()
    {
        $projectMedia = $this->mediaProjectRepository->getOneWithProjectById(request('id'));
        $this->uploadedFilesService->removeFile('/public/images/uploads/' . $projectMedia->project->client->slug . '/projets/' . Str::slug($projectMedia->project->title) . '/' . $projectMedia->mediaProjectPath);

        return response()->json('success');
    }

    public function updateActive()
    {
        $project = Project::whereSlug(request('slug'))->first();
        $this->projectRepository->changeActive($project);
    }

    private function addinarray(&$array,$after, $value, $position){
        $offset = array_search($after, $array);
        if ($position == 'after') {
            $index = $offset+1;
        } else {
            $index = $offset;
        }
        array_splice($array, $index, 0, $value);
    }
}
