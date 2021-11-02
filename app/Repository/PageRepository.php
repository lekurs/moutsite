<?php


namespace App\Repository;


use App\Models\Page;
use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class PageRepository
{

    public function getAllByProject(Project $project): Collection
    {
        return Page::query()->where('project_id', $project->id)->get();
    }

    public function store(array $data)
    {
        $page = new Page();
        $page->label = $data['page_label'];
        $page->url_path = $data['page_url_path'];
        $page->slug = Str::slug($data['page_label']);
        $page->project_id = $data['project_id'];
        $page->save();

//        $page->users()->sync($data['contact_id']);

    }
}
