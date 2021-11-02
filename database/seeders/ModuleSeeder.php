<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach(config('roles.modules') as $module) {
            $mod = new Module();
            $mod->label = $module;
            $mod->save();
        }
    }
}
