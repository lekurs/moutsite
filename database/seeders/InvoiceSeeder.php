<?php

namespace Database\Seeders;

use App\Models\Estimation;
use App\Models\Invoice;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Invoice::factory()->count(80)->create();
    }
}
