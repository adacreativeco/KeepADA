<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Equipment;

class EquipmentPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Equipment $equipment): bool
    {
        return $user->canAccessCompany($equipment->company);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'manager', 'technician']);
    }

    public function update(User $user, Equipment $equipment): bool
    {
        return $user->canAccessCompany($equipment->company) && $user->hasAnyRole(['super_admin', 'manager', 'technician']);
    }

    public function delete(User $user, Equipment $equipment): bool
    {
        return $user->canAccessCompany($equipment->company) && $user->hasAnyRole(['super_admin', 'manager']);
    }
}