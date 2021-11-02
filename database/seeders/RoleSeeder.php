<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        foreach (config('init_role') as $role) {
            $created = Role::create([
                'name' => $role['name'],
                'slug' => $role['slug'],
                'description' => $role['description'],
                'created_at' => now(),
                'updated_at' => now()
            ]);

//            $permissions = Permission::query()->whereIn('key', $role['permissions'])->get();
//            $created->permissions()->attach($permissions);
        }
    }
}
