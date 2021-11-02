<?php


namespace App\Repository;


use App\Models\Skill;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\QueryException;

class SkillRepository
{
    public function getAll(): Collection
    {
        return Skill::all();
    }

    public function getOneById($id): Skill
    {
        return Skill::whereId($id)->first();
    }

    public function updateStatus(int $skillId): void
    {
        $skill = $this->getOneById($skillId);

        if($skill->status === 1) {
            $skill->status = 0;
            $skill->save();
        } else {
            $skill->status = 1;
            $skill->save();
        }
    }

    public function store(array $datas): void
    {
        if (!empty($datas['skill_id'])) {
            $skill = $this->getOneById($datas['skill_id']);
            $skill->skill = $datas['skill-libelle'];
            $skill->save();
        } else {
            if (is_array($datas['skill-libelle'])) {

                foreach ($datas['skill-libelle'] as $skillWording) {
                    $skill = new Skill();
                    $skill->libelle = $skillWording;
                    try {
                        $skill->save();

                    } catch (QueryException $e) {
                        dd($e->getMessage());
                    }
                }
            } else {

                $skill = new Skill();
                $skill->skill = $datas['skill-libelle'][0];

                try {
                    $skill->save();

                } catch (QueryException $e) {
                    dd($e->getMessage());
                }
            }
        }
    }

    public function delete(int $skillId): void
    {
        $skill = $this->getOneById($skillId);
        $skill->delete();
    }
}
