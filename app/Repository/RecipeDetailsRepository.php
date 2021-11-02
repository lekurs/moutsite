<?php

namespace App\Repository;

use App\Models\Recipe;
use App\Models\RecipeDetails;
use Illuminate\Database\Eloquent\Collection;

class RecipeDetailsRepository
{
    public function getAllByRecipe(Recipe $recipe): Collection
    {
        return RecipeDetails::whereRecipeId($recipe->id)->orderBy('created_at')->get();
    }

    public function store(array $data, Recipe $recipe)
    {
        $recipeDetail = new RecipeDetails();

        if (isset($data['recipe_answer_image'])) {
            $recipeDetail->picture_path = $data['recipe_answer_image']->getClientOriginalName();
        }

        $recipeDetail->description = $data['recipe_description'];
        $recipeDetail->slug = \Str::slug($data['recipe_description']);
        $recipeDetail->user_id = auth()->user()->id;
        $recipeDetail->recipe_id = $recipe->id;

        $recipeDetail->save();
    }
}
