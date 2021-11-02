<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(['Web', 'UX / UI', 'Print'] as $skill) {
            Skill::create([
                'libelle' => $skill,
            ]);
        }
    }
}
