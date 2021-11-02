<?php


namespace App\Http\Controllers\Admin;


use App\Models\Skill;
use App\Repository\SkillRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSkill;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class SkillController extends Controller
{
    private SkillRepository $skillRepository;

    /**
     * SkillController constructor.
     * @param SkillRepository $skillRepository
     */
    public function __construct(SkillRepository $skillRepository)
    {
        $this->skillRepository = $skillRepository;
    }


    public function index(): View
    {
        $skills = $this->skillRepository->getAll();

        return view('pages.admin.skills.index', [
            'skills' => $skills
        ]);
    }

    public function show(Skill $skill): View
    {
        $oneSkill = $this->skillRepository->getOneById($skill->id);

        return view('pages.admin.skills.show', [
           'skill' => $oneSkill
        ]);
    }

    public function store(StoreSkill $storeSkill): RedirectResponse
    {
        $this->skillRepository->store($storeSkill->validated());

        return redirect()->route('skills.index')->with('success', 'Compétence ajoutée');
    }

    public function status(Skill $skill)
    {
        $this->skillRepository->updateStatus($skill->id);

        return back()->with('success', 'Status modifié');
    }

    public function update(StoreSkill $storeSkill): RedirectResponse
    {
        $this->skillRepository->store($storeSkill->validated());

        return redirect()->route('skills.index')->with('success', 'Votre compétence à été mise à jour');
    }

    public function destroy(Skill $skill): RedirectResponse
    {
        $this->skillRepository->delete($skill->id);

        return back()->with('success', 'Compétence supprimée');
    }
}
