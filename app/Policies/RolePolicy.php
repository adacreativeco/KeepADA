<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RolePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    public function view(User $user, Role $role): bool
    {
        return $user->hasRole('super_admin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    public function update(User $user, Role $role): bool
    {
        return $user->hasRole('super_admin');
    }

    public function delete(User $user, Role $role): bool
    {
        return $user->hasRole('super_admin');
    }
}