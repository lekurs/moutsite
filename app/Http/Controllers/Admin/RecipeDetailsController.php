<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRecipeAnswer;
use App\Models\Recipe;
use App\Notifications\RecipeEmailNotification;
use App\Repository\RecipeDetailsRepository;
use App\Services\Uploads\UploadedFilesService;

class RecipeDetailsController extends Controller
{
    private RecipeDetailsRepository $recipeDetailRepository;

    private UploadedFilesService $uploadedFilesService;

    /**
     * @param RecipeDetailsRepository $recipeDetailRepository
     * @param UploadedFilesService $uploadedFilesService
     */
    public function __construct(
        RecipeDetailsRepository $recipeDetailRepository,
        UploadedFilesService $uploadedFilesService
    ) {
        $this->recipeDetailRepository = $recipeDetailRepository;
        $this->uploadedFilesService = $uploadedFilesService;
    }


    public function index(Recipe $recipe)
    {
        $responses = $this->recipeDetailRepository->getAllByRecipe($recipe);

        return view();
    }

    public function show()
    {

    }

    public function store(StoreRecipeAnswer $storeRecipeAnswer, Recipe $recipe)
    {
        $data = $storeRecipeAnswer->validated();

        if(isset($data['recipe_answer_image']) && !is_null($data['recipe_answer_image'])) {
            $this->uploadedFilesService->moveFile($data['recipe_answer_image'], '/public/images/uploads/' . $recipe->project->client->slug . '/projets/' . $recipe->project->slug . '/recipe/');
        }

        $this->recipeDetailRepository->store($data, $recipe);

        foreach($recipe->users as $contact) {

            $contact->notify(new RecipeEmailNotification($recipe, $data['recipe_description']));
        }

        return back()->with('success', 'Votre message à été ajouté');
    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
