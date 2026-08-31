<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Supplier;

class SupplierPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Supplier $supplier): bool
    {
        return $user->canAccessCompany($supplier->company);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'manager']);
    }

    public function update(User $user, Supplier $supplier): bool
    {
        return $user->canAccessCompany($supplier->company) && $user->hasAnyRole(['super_admin', 'manager']);
    }

    public function delete(User $user, Supplier $supplier): bool
    {
        return $user->canAccessCompany($supplier->company) && $user->hasAnyRole(['super_admin', 'manager']);
    }
}
