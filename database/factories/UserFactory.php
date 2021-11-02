<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Maxime',
            'lastname' => 'Gindre',
            'email' => 'gindre.maxime@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('mg261181'), // password
            'slug' => 'maxime-gindre',
            'user_group' => 'admin',
            'remember_token' => Str::random(10),
        ];
    }
}
