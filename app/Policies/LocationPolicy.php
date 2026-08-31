<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Location;

class LocationPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Location $location): bool
    {
        return $user->canAccessCompany($location->company);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'manager']);
    }

    public function update(User $user, Location $location): bool
    {
        return $user->canAccessCompany($location->company) && $user->hasAnyRole(['super_admin', 'manager']);
    }

    public function delete(User $user, Location $location): bool
    {
        return $user->canAccessCompany($location->company) && $user->hasAnyRole(['super_admin', 'manager']);
    }
}