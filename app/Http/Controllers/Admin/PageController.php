<?php


namespace App\Http\Controllers\Admin;


use App\Models\Project;
use App\Repository\PageRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePage;
use Illuminate\Contracts\View\View;

class PageController extends Controller
{
    private PageRepository $pageRepository;

    /**
     * PageController constructor.
     * @param PageRepository $pageRepository
     */
    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function index(Project $project)
    {
        $pages = $this->pageRepository->getAllByProject($project);

        return \view('pages.admin.recipes.pages.index', [
            'project' => $project,
            'pages' => $pages
        ]);
    }

    public function store(StorePage $storePage)
    {
        $data = $storePage->validated();

        $this->pageRepository->store($data);

        return redirect()->back();
    }

    public function destroy()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }
}
