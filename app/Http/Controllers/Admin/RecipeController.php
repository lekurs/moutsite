<?php


namespace App\Http\Controllers\Admin;


use App\Models\Client;
use App\Models\Device;
use App\Models\Page;
use App\Models\Project;
use App\Models\Recipe;
use App\Repository\RecipeRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecipe;
use App\Services\Uploads\UploadedFilesService;
use Illuminate\Support\Str;

class RecipeController extends Controller
{

    /**
     * RecipeController constructor.
     * @param RecipeRepository $recipeRepository
     * @param UploadedFilesService $uploadedFilesService
     */
    public function __construct(
        private RecipeRepository $recipeRepository,
        private UploadedFilesService $uploadedFilesService
    ) { }


    public function index(Page $page, Project $project)
    {
        $recipes = $this->recipeRepository->getAllByProject($project, $page);
        $devices = Device::all();

        return \view('pages.admin.recipes.index', [
            'project' => $project,
            'recipes' => $recipes,
            'devices' => $devices,
            'page' => $page
        ]);
    }

//    public function all()
//    {
//        $recipes = Recipe::whereClientId(auth()->user()->client_id)->get();
//
//        return \view('pages.admin.recipes.pub.index', [
//            'recipes' => $recipes,
//        ]);
//    }

    public function show(Recipe $recipe)
    {
        return \view('pages.admin.recipes.show', [
            'recipe' => $recipe
        ]);
    }

    public function create(Page $page, Project $project)
    {

        $devices = Device::all();

        return view('pages.admin.recipes.create', [
            'project' => $project,
            'page' => $page,
            'devices' => $devices
        ]);
    }

//    public function createRecipe(Project $project)
//    {
//        $pages = Page::whereProjectId($project->id)->with('project')->get();
//        $devices = Device::all();
//
//        return view('pages.admin.recipes.create_recipe', [
//            'project' => $project,
//            'pages' => $pages,
//            'devices' => $devices
//        ]);
//    }

    public function store(StoreRecipe $storeRecipe)
    {
        $data = $storeRecipe->validated();
        $this->recipeRepository->store($data);

        $this->uploadedFilesService->moveFile($data['recipe_image'], 'public/images/uploads/' . Str::slug(Client::whereId($data['recipe_client_id'])->first()->name) . '/recipes/');

        return redirect()->back();
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function updateStatus(Recipe $recipe)
    {
        $status = $this->recipeRepository->updateStatus($recipe);

        if($status === true) {
            return back()->with('success', 'La recette est à présent terminée');
        } else {
            return back()->with('success', 'La recette est à présent en cours');
        }
    }

    public function destroy()
    {

    }
}
