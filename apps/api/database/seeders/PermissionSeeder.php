<?php

namespace Database\Seeders;

use App\Enums\PermissionType;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (PermissionType::cases() as $permission) {

            Permission::firstOrCreate([

                'name' => $permission->value,
                'guard_name' => config('auth.defaults.guard'),

            ]);
        }
    }
}
