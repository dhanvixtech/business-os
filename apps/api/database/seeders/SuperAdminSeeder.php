<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(

            [
                'email' => 'admin@businessos.test',
            ],

            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]

        );

        $user->assignRole(
            RoleType::SUPER_ADMIN->value
        );
    }
}
