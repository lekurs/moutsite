<?php

namespace App\Http\Controllers\Security;

use App\Models\Permission;
use App\Models\Role;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();

        return view('pages.admin.roles.index', [
            'roles' => $roles
        ]);
    }

    public function show(Role $role)
    {
        $rolePermissions = $role->permissions->pluck('key')->toArray();
        $permissions = Permission::all();
    }

    public function create()
    {
        $permissions = Permission::all();

        return view('pages.admin.roles.create', [
            'permissions' => $permissions
        ]);
    }

    public function store()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function destroy()
    {

    }
}
