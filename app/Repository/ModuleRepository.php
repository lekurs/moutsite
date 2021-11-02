<?php

namespace App\Repository;

use App\Models\Module;
use App\Models\Role;

class ModuleRepository
{
    /**
     * @param string $name
     * @return mixed
     */
    public function getByClassName(string $classname)
    {
        return Module::query()->whereClassname($classname)->first();
    }

    public function update($model, $module)
    {
        $data = $model->module;
        $module->label = (!isset($data['name'])) ? str_replace('App\\Models\\', '', get_class($model)) : $data['name'];
        $module->classname = str_replace('App\\Models\\', '', get_class($model));
        $module->description = (isset($data['description'])) ? $data['description'] : "";

        $module->save();
    }

    /**
     * @param $model
     * @return Module
     */
    public function store($model)
    {
        $data = $model->module;

        $mod = new Module();
        $mod->label = (!isset($data['name'])) ? str_replace('App\\Models\\', '', get_class($model)) : $data['name'];
        $mod->classname = str_replace('App\\Models\\', '', get_class($model));
        $mod->description  = (isset($data['description'])) ? $data['description'] : "";

        $mod->save();

        Role::create($mod->label);

        return $mod;

    }

    public function destroy(Module $module)
    {
        $module->delete();
    }
}
