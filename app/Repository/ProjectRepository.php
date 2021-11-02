<?php


namespace App\Repository;


use App\Models\MediaProject;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class ProjectRepository
{
    public function getAll(): Collection
    {
        return Project::with('client')->get();
    }

    public function getOneBySlug(string $slug): Project
    {
        return Project::whereSlug($slug)->first();
    }

    public function getAllWithMediasOrderByNewer(): Collection
    {
        return Project::with('client', 'mediaProjects')
            ->orderBy('endProject')
            ->get();
    }

    public function getAllWithSearchBar(string $title = null, int $skill = null)
    {
        $q = Project::with(['client', 'mediaProjects', 'skills']);

        if (!is_null($skill)) {
         $q->whereHas('skills', function(Builder $q) use($skill) {
                $q->whereId($skill);
            });
        }
            $q->where('title', 'like', $title . '%');

        return $q->paginate(4);
    }

    public function getOneBySLugWithMediasOrderByDisplay(string $slug): Project
    {
        return Project::with(['client', 'mediaProjects' => function ($q) {
            $q->orderBy('displayOrder', 'ASC');
        }])->whereSlug($slug)
            ->first();
    }

    public function getAllNoRecipe(): Collection
    {
        return Project::with(['client', 'mediaProjects'])->whereDoesntHave('recipe_id')->get();
    }

    public function getAllBy4(): Paginator
    {
        return Project::with('client', 'mediaProjects')
            ->orderBy('endProject')
            ->paginate(4);
    }

    public function getAllBy12(): Paginator
    {
        return Project::with('client', 'mediaProjects')
            ->orderBy('endProject')
            ->paginate(12);
    }

    public function changeActive(Project $project)
    {
        if ($project->in_progress > 0) {
            $project->in_progress = 0;
            $project->save();
        } else {
            $project->in_progress = 1;
            $project->save();
        }
    }

    public function store(array $data): void
    {
        $project = new Project();
        $project->title = $data['project-title'];
        $project->created_at = date('Y-m-d', strtotime($data['project-start']));
        $project->endProject = date('Y-m-d', strtotime($data['project-end']));
        $project->description = $data['project-description'];
//        $project->result = $data['project-result-mission'];
//        $project->mediaPortfolioProjectPath = $data['project-img-portfolio']->getClientOriginalName();
//        $project->background_img_path = $data['project-background-img']->getClientOriginalName();
//        $project->colorProject = $data['project_color'];
        $project->slug = Str::slug($data['project-title']);
        $project->client_id = $data['client-id'];

//        dd($data['project-contact']);

        $project->save();

        if(count($data['project-contact']) > 1) {
            $project->users()->attach($data['project-contact']);
        } else {
            foreach ($data['project-contact'] as $contact) {
                $project->users()->attach($contact);
            }
        }

//        if (isset($data['project-service'])) {
//            foreach ($data['project-service'] as $service) {
//                $project->services()->sync($service, false);
//            }
//        }
//
//        if (isset($data['skills']) && !is_null($data['skills'])) {
//            foreach ($data['skills'] as $skill) {
//                $project->skills()->sync($skill, false);
//            }
//        }
//
//        $lastId = $project->id;
//
//        if (isset($data['image']) && !is_null($data['image'])) {
//            foreach ($data['image'] as $key => $file) {
//                $mediaProject = new MediaProject();
//                $mediaProject->mediaProjectPath = $file->getClientOriginalName();
//                $mediaProject->displayOrder = ($key+1);
//                $mediaProject->project_id = $lastId;
//
//                $mediaProject->save();
//            }
//        }
    }

    public function editProjectMedias(array $data)
    {
        $project = Project::whereId($data['project-id'])->first();
        //
    }

    public function editStore(array $data)
    {
        if(isset($data['project-id']) && !is_null($data['project-id'])) {
            $project = Project::whereId($data['project-id'])->first();

            $project->title = $data['project-title'];
            if (isset($data['project_color'])) {
                $project->colorProject = $data['project_color'];
            }
            $project->mission = $data['project-description-mission'];
            $project->result = $data['project-result-mission'];
            $project->slug = Str::slug($data['project-title']);

            if (isset($data['img-project-portfolio'])) {
                $project->mediaPortfolioProjectPath = $data['img-project-portfolio']->getClientOriginalName();
            }

            if (isset($data['project-background-img'])) {
                $project->background_img_path = $data['project-background-img']->getClientOriginalName();
            }

            $project->save();
        }
    }

    public function delete(string $slug)
    {
        $project = $this->getOneBySlug($slug);
        $project->delete();
    }
}
