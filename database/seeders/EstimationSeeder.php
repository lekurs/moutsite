<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Estimation;
use App\Models\User;
use Illuminate\Database\Seeder;

class EstimationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Estimation::factory()->count(40)->create();
    }
}
