<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Estimation;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $amount = $this->faker->randomNumber(5, true);
        return [
            'reference' => '2021' . $this->faker->month . $this->faker->numberBetween(001, 100),
            'advance' => $this->faker->boolean,
            'amount_no_tax' => $amount,
            'amount' => $amount*1.2,
            'amount_tax' => (($amount*1.2) - $amount),
            'paid' => $this->faker->boolean,
            'month' => $this->faker->month,
            'year' => $this->faker->numberBetween(2020, 2021),
            'observation' => $this->faker->realText(40),
            'created_at' => now(),
            'updated_at' => now(),
            'estimation_id' => Estimation::all()->random()->id,
            'client_id' => Client::all()->random()->id,
        ];
    }
}
