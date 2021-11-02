<?php


namespace App\Repository;


use App\Models\Client;
use App\Models\MediaProject;
use App\Models\Project;

class MediaProjectRepository
{

    public function getAll()
    {
        return MediaProject::all();
    }

    public function getAllMediasByProject(Project $project)
    {
        return MediaProject::whereProjectId($project->id)->get()->toArray();
    }

    public function removeMediaOrder(Project $project)
    {
        $medias = MediaProject::whereProjectId($project->id)->get();

        foreach($medias as $media) {
            $media->displayOrder = null;
            $media->save();
        }
    }

    public function getOneWithProjectById(int $id)
    {
        $media = MediaProject::with('project')->whereId($id)->first();
        $media->delete();

        return $media;
    }

    public function storeAndReorganizeOrder(Project $project, $file, array $medias)
    {
        $newMedia = new MediaProject();
        $newMedia->project_id = $project->id;
        $newMedia->mediaProjectPath = $file->getClientOriginalName();
        $newMedia->save();

        foreach($medias as $key => $media) {
            $h = MediaProject::where('mediaProjectPath', $media)->first();
            $h->displayOrder = $key;
            $h->save();
        }
    }
}
