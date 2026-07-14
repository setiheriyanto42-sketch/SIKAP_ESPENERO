<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(

            [
                'username' => 'admin',
            ],

            [
                'guru_id' => null,

                'role_id' => 1,

                'username' => 'admin',

                'name' => 'Administrator',

                'email' => 'admin@sikap.local',

                'password' => Hash::make('admin123'),

            ]

        );
    }
}
