<?php

namespace App\Repository;

use App\Models\Module;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;

class PermissionRepository
{
    protected $cruds = [
        'add' => 'Ajouter',
        'destroy' => 'Supprimer',
        'update' => 'Mettre à jour',
        'show' => 'Voir'
    ];


    public function getAll()
    {
        return Permission::all();
    }

    public function getAllByModule(Module $module)
    {
        return Permission::query()->whereModuleId($module->id)->get();
    }

    public function store(Model $modelInstance, $modelRepo)
    {
        foreach($this->cruds as $key => $crud) {
            $permission = new Permission();
            $permission->key = $key . '.' . strtolower(class_basename($modelInstance));
            $permission->name = $crud . ' ' . strtolower(class_basename($modelInstance));
            $permission->module_id = $modelRepo->id;

            $permission->save();

            //l'admin à tous les droits
            $role = Role::query()->whereSlug('admin')->first();

            $permission->roles()->attach($role);
       }

        if(isset($modelInstance->permissions)) {
            if (is_array($modelInstance->permissions)) {
                foreach ($modelInstance->permissions as $permission) {
                    if (isset($permission['key'])) {

                        $permissionModel = new Permission();
                        $permissionModel->key = $permission['key'];
                        $permissionModel->name = $permission['name'] ?? "";
                        $permissionModel->description = $permission['description'] ?? "";
                        $permissionModel->locked = false;
                        $permissionModel->module_id = $modelRepo->id;

                        $permissionModel->save();

                        if (isset($permission['role'])) {

                            $role = Role::query()->whereSlug($permission['role'])->first();
                            $permissionModel->roles()->attach($role);

                        } else {

                            $role = Role::query()->whereSlug('default')->first();
                            $permissionModel->roles()->attach($role);
                        }
                    }
                }
            }
        }
    }

    public function destroy(Module $module)
    {
        $permissions = Permission::query()->whereModuleId($module->id)->get();

        foreach ($permissions as $permission) {

            if ($permission->locked == false) {

                $permission->delete();
            }
        }
    }

    public function update(array $permissions, Module $module)
    {
        //On supprime toutes les permission hors CRUD
        $perms = Permission::query()->whereModuleId($module->id)->whereLocked(false)->get();

       $permTab = [];
       $permbdd = [];

        foreach ($permissions as $permission) {
            $permTab[$permission['key']] = $permission;
        }

        foreach ($perms as $perm) {
            $permbdd[$perm->key] = $perm;
        }

        //Les créations
        $created = array_diff_key($permTab, $permbdd);

        foreach ($created as $create) {
            $permissionModel = new Permission();
            $permissionModel->key = $create['key'];
            $permissionModel->name = $create['name'] ?? "";
            $permissionModel->description = $create['description'] ?? "";
            $permissionModel->locked = false;
            $permissionModel->module_id = $module->id;

            $permissionModel->save();

            if(isset($create['role'])) {

                $role = Role::whereName($create['role'])->first();

                if (!is_null($role)) {
                    $permissionModel->roles()->sync($role);
                } else {
                    echo "Ce rôle [". $create['role'] ."] n'existe pas dans l'entité [". $module->label . "]" . PHP_EOL;
                }
            } else {

                $role = Role::whereSlug('default')->first();
                $permissionModel->roles()->sync($role);
            }
        }

        //Les suppressions
        $deletes = array_diff_key($permbdd, $permTab);

        foreach ($deletes as $delete) {
            $delete->delete();
        }

        //Les modifications
        $updates = array_intersect_key($permbdd, $permTab);

        foreach ($updates as $update) {
            $update->key = $permTab[$update->key]['key'];
            $update->name = $permTab[$update->key]['name'] ?? "";
            $update->description = $permTab[$update->key]['description'] ?? "";

            $update->save();

            if(isset($permTab[$update->key]['role'])) {

                $role = Role::whereName($permTab[$update->key]['role'])->first();

                if (!is_null($role)) {
                    $update->roles()->sync($role);
                } else {
                    echo "Ce rôle [". $permTab[$update->key]['role'] ."] n'existe pas dans l'entité [". $module->label . "]" . PHP_EOL;
                }
            } else {

                $role = Role::whereSlug('default')->first();
                $update->roles()->sync($role);
            }
        }
    }
}
