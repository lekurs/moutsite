<?php

namespace Database\Seeders;

use App\Models\Estimation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
//           PermissionSeeder::class,
           RoleSeeder::class,
           CreateAdminUserSeeder::class,
           DeviceSeeder::class,
           SkillSeeder::class,
           ClientSeeder::class,
           EstimationSeeder::class,
           InvoiceSeeder::class,
           ProjectSeeder::class,
//           ModuleSeeder::class
        ]);

    }
}
