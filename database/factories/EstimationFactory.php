<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Estimation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EstimationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Estimation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'reference' => '2021' . $this->faker->month . $this->faker->numberBetween(001, 100),
            'title' => $this->faker->text('200'),
            'validation' => $this->faker->boolean,
            'month' => $this->faker->month,
            'year' => $this->faker->numberBetween(2020, 2021),
            'validation_duration' => 30,
            'created_at' => now(),
            'updated_at' => now(),
            'client_id' => Client::all()->random()->id,
            'user_id' => User::all()->random()->id,
            'contact_validator_id' => User::all()->random()->id
        ];
    }
}
