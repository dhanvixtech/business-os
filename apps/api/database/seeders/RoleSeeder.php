<?php

namespace Database\Seeders;

use App\Enums\RoleType;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach (RoleType::cases() as $role) {

            $createdRole = Role::firstOrCreate([
                'name' => $role->value,
                'guard_name' => config('auth.defaults.guard'),
            ]);

            if ($role->value === RoleType::SUPER_ADMIN->value) {

                $createdRole->syncPermissions(
                    Permission::all()
                );
            }
        }
    }
}
