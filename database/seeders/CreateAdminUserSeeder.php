<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        DB::table('users')->truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        $users = [
            ['name' => 'Maxime',
                'lastname' => 'Gindre',
                'email' => 'gindre.maxime@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('mg261181'), // password
                'slug' => 'maxime-gindre',
                'user_group' => 'admin',
                'remember_token' => Str::random(10)
            ],
            [
                'name' => 'Bidule',
                'lastname' => 'Truc',
                'email' => 'bidule@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('mg261181'), // password
                'slug' => 'bidule',
                'user_group' => 'guest',
                'remember_token' => Str::random(10),
                'client_id' => 1
            ],
            [
                'name' => 'Machin',
                'lastname' => 'Bolobolo',
                'email' => 'machin@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('mg261181'), // password
                'slug' => 'machin',
                'user_group' => 'client',
                'remember_token' => Str::random(10),
                'client_id' => 2
            ]
        ];

        foreach ($users as $user) {
            $newUser = User::create($user);
            $newUser->roles()->attach(1);
        }
        User::find(1)->roles()->attach(2);
        User::find(2)->roles()->attach(3);
    }
}
