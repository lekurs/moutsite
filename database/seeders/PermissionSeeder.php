<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('permissions_roles')->truncate();
        DB::table('roles_users')->truncate();
        DB::table('roles')->truncate();
        DB::table('permissions')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        foreach (config('roles.permissions') as $permission) {
            Permission::create([
                'key' => $permission['key'],
                'name' => $permission['name'],
                'description' => $permission['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
