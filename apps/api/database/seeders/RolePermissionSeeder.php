<?php

namespace Database\Seeders;

use App\Enums\PermissionType;
use App\Enums\RoleType;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $this->assignSuperAdminPermissions();
        $this->assignManagerPermissions();
        $this->assignEmployeePermissions();
        $this->assignCustomerPermissions();
    }

    private function assignSuperAdminPermissions(): void
    {
        $role = Role::findByName(
            RoleType::SUPER_ADMIN->value,
            'sanctum'
        );

        $role->syncPermissions(
            PermissionType::values()
        );
    }

    private function assignManagerPermissions(): void
    {
        $role = Role::findByName(
            RoleType::MANAGER->value,
            'sanctum'
        );

        $role->syncPermissions([
            PermissionType::USERS_VIEW->value,
            PermissionType::USERS_CREATE->value,
            PermissionType::USERS_UPDATE->value,

            PermissionType::ROLES_VIEW->value,

            PermissionType::PERMISSIONS_VIEW->value,
        ]);
    }

    private function assignEmployeePermissions(): void
    {
        $role = Role::findByName(
            RoleType::EMPLOYEE->value,
            'sanctum'
        );

        $role->syncPermissions([
            PermissionType::USERS_VIEW->value,
        ]);
    }

    private function assignCustomerPermissions(): void
    {
        $role = Role::findByName(
            RoleType::CUSTOMER->value,
            'sanctum'
        );

        $role->syncPermissions([]);
    }
}
