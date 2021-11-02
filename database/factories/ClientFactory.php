<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->company;

        return [
            'name' => $name,
            'phone' => $this->faker->e164PhoneNumber,
            'address' => $this->faker->address,
            'zip' => $this->faker->randomNumber(5, true),
            'city' => $this->faker->city,
            'siren' => $this->faker->numerify('##########'),
            'slug' => \Str::slug($name),
            'logo' => $this->faker->imageUrl(300, 200),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
