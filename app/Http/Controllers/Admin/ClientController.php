<?php


namespace App\Http\Controllers\Admin;


use App\Models\Client;
use App\Models\Permission;
use App\Models\Role;
use App\Repository\ClientRepository;
use App\Repository\EstimationDetailRepository;
use App\Repository\InvoiceRepository;
use App\Repository\SkillRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClient;
use App\Repository\UserRepository;
use App\Services\Uploads\UploadedFilesService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    public function __construct(
         private ClientRepository $clientRepository,
         private SkillRepository $skillRepository,
         private UploadedFilesService $uploadedFilesService,
         private EstimationDetailRepository $estimationDetailRepository
    ) {}

    /**
     * @return View
     */
    public function index(): View
    {
        $clients = $this->clientRepository->getAllWithPaginate();
        $skills = $this->skillRepository->getAll();

        return \view('pages.admin.clients.index', [
            'clients' => $clients,
            'skills' => $skills,
        ]);
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return \view('pages.admin.clients.create');
    }

    /**
     * @param StoreClient $storeClient
     * @return RedirectResponse
     */
    public function store(StoreClient $storeClient): RedirectResponse
    {
        $dataClient = $storeClient->validated();

        $file = null;

        if (isset($storeClient['client-logo']) && !is_null($storeClient['client-logo'])) {
            $file = request()->file('client-logo');
        }

        $this->clientRepository->store($dataClient, $file);

        $this->uploadedFilesService->moveFile($file, '/public/images/uploads/' . Str::slug($dataClient['client-name']) . '/logo');

        return redirect()->route('clients.index')->with('success', 'Client ajouté');
    }

    /**
     * @param Client $client
     * @return View
     */
    public function show(Client $client)
    {
//        dd(auth()->user()->roles()->each(function (Role $role) {
//            dump($role->name);
//            $role->permissions()->each(function (Permission $permission) {
//               dump($permission->key);
//            });
//        }));
        if (auth()->user()->canAny(['show.one.client', 'show.client'])) {

            $skills = $this->skillRepository->getAll();
            $estimations = $client->estimations;
    //        $invoices = $this->invoiceRepository->getByClient($client);
    //        $estimationsByClient = [];

    //        foreach($client->estimations()->get()->where('created_at', '>=', date('Y-m-d', strtotime('-1 years'))) as $estimation) {
    //            $estimations[] = $this->estimationDetailRepository->getTotal($estimation);
    //        }

    //        foreach($client->estimations->where('client_id', '=', $client->id) as $estimation) {
    //            $invoices[] = $this->invoiceRepository->getByEstimation($estimation);
    //        }

            $sumEstimations = $this->estimationDetailRepository->getTotalOnThisYear($client);

            return view('pages.admin.clients.show', [
                'client' => $client,
                'skills' => $skills,
                'estimations'=> $estimations,
                'sumEstimations' => $sumEstimations,
    //            'invoices' => $invoices
            ]);
        }
    }

    /**
     * @param Client $client
     * @return View
     */
    public function edit(Client $client)
    {
        $data = $this->clientRepository->getOneBySlug($client->slug);

        return \view('pages.admin.clients.edit', [
            'client' => $data
        ]);
    }

    /**
     * @param StoreClient $storeClient
     * @param Client $client
     * @return RedirectResponse
     */
    public function update(StoreClient $storeClient, Client $client)
    {
        if (isset($storeClient['client-logo'])) {
            $file = $storeClient['client-logo'];

            $this->clientRepository->store($storeClient->all(), $file);

            $this->uploadedFilesService->moveFile($file, '/public/images/uploads/' . Str::slug($storeClient['client-name']) . '/logo');
        } else {
            $this->clientRepository->store($storeClient->all(), null);
        }

        return redirect()->route('clients.index`')->with('success', 'Client mis à jour');
    }

    public function destroy()
    {

    }

    /**
     * @param Client $client
     * @return View
     */
    public function search(Client $client)
    {
        $clients = $this->clientRepository->search($client->name);

        return view('admin.clients.show_all_client', [
            'clients' => $clients
        ]);
    }

}
