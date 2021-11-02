<?php


namespace App\Repository;


use App\Models\Client;
use App\Models\Page;
use App\Models\Project;
use App\Models\Recipe;
use Illuminate\Support\Str;

class RecipeRepository
{
    public function getAllByProject(Project $project, Page $page)
    {
        return Recipe::with('devices')->whereProjectId($project->id)->wherePageId($page->id)->orderBy('page_id')->whereNotNull('user_id')->get();
    }

    public function getOneWithPages(Project $project)
    {
        return Recipe::with('pages')->whereProjectId($project->id)->get();
    }

    public function updateStatus(Recipe $recipe)
    {
        if($recipe->status === 1) {
            $recipe->status = 0;
            $recipe->closed_date = new \DateTime('now');
            $recipe->save();

            return true;
        } else {
            $recipe->status = 1;
            $recipe->closed_date = null;
            $recipe->save();

            return false;
        }
    }

    public function store(array $data)
    {
        $recipe = new Recipe();
        if (isset($data['recipe_image'])) {
            $recipe->picture_path = $data['recipe_image']->getClientOriginalName();
        }

        $recipe->label = $data['recipe_label'];
        $recipe->description = $data['recipe_description'];
        $recipe->slug = Str::slug($data['recipe_label']);
        $recipe->page_id = $data['recipe_page_id'];
        $recipe->user_id = auth()->user()->id;
        $recipe->client_id = $data['recipe_client_id'];
        $recipe->project_id = $data['recipe_project_id'];

        $recipe->save();

        if(count($data['recipe_device_id']) > 1) {
            foreach ($data['recipe_device_id'] as $device) {
                $recipe->devices()->attach($device);
            }
        } else {
            $recipe->devices()->attach([$data['recipe_device_id'][0]]);
        }

        if(count($data['recipe_member']) > 1) {
            foreach($data['recipe_member'] as $user) {
                $recipe->users()->attach($user);
            }
        } else {
            $recipe->users()->attach($data['recipe_member']);
        }

        $recipe->users()->attach([auth()->user()->id]);
    }
}
