<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SparePart;

class SparePartPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, SparePart $sparePart): bool
    {
        return $user->canAccessCompany($sparePart->company);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'manager', 'technician']);
    }

    public function update(User $user, SparePart $sparePart): bool
    {
        return $user->canAccessCompany($sparePart->company) && $user->hasAnyRole(['super_admin', 'manager', 'technician']);
    }

    public function delete(User $user, SparePart $sparePart): bool
    {
        return $user->canAccessCompany($sparePart->company) && $user->hasAnyRole(['super_admin', 'manager']);
    }
}