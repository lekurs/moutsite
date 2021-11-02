<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        foreach(['Desktop', 'Mobile', 'Tablette'] as $device) {
            Device::create([
                'libelle' => $device,
                'slug' => Str::slug($device)
            ]);
        }
    }
}
