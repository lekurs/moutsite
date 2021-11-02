<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(200);
        return [
            'title' => $title,
            'description' => $this->faker->text(400),
            'slug' => Str::slug($title),
            'in_progress' => $this->faker->boolean,
            'endProject' => $this->faker->date('Y-m-d', now()),
            'client_id' => Client::all()->random()->id,
        ];
    }
}
