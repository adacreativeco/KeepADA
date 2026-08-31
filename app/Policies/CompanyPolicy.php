<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Company;

class CompanyPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    public function view(User $user, Company $company): bool
    {
        return $user->canAccessCompany($company);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('super_admin');
    }

    public function update(User $user, Company $company): bool
    {
        return $user->canAccessCompany($company) && $user->hasAnyRole(['super_admin', 'manager']);
    }

    public function delete(User $user, Company $company): bool
    {
        return $user->hasRole('super_admin');
    }
}
