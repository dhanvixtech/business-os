<?php

namespace App\Policies;

use App\Enums\RoleType;
use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('users.view');
    }

    public function view(User $user, User $target): bool
    {
        return $user->can('users.view');
    }

    public function create(User $user): bool
    {
        return $user->can('users.create');
    }

    public function update(User $user, User $target): bool
    {
        if (! $user->can('users.update')) {
            return false;
        }

        if ($user->hasRole(RoleType::SUPER_ADMIN->value)) {
            return true;
        }

        if ($user->id === $target->id) {
            return true;
        }

        return $user->hasRole(RoleType::MANAGER->value)
            && ! $target->hasRole(RoleType::SUPER_ADMIN->value);
    }

    public function delete(User $user, User $target): bool
    {
        // Must have the permission first
        if (! $user->can('users.delete')) {
            return false;
        }

        // Super Admin can delete anyone except himself
        if ($user->hasRole(RoleType::SUPER_ADMIN->value)) {
            return $user->id !== $target->id;
        }

        // Manager can delete non-Super Admin users
        if (
            $user->hasRole(RoleType::MANAGER->value)
            && ! $target->hasRole(RoleType::SUPER_ADMIN->value)
        ) {
            return true;
        }

        return false;
    }
}
