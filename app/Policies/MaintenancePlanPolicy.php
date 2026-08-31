<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MaintenancePlan;

class MaintenancePlanPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, MaintenancePlan $plan): bool
    {
        return $user->canAccessCompany($plan->company);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'manager', 'technician']);
    }

    public function update(User $user, MaintenancePlan $plan): bool
    {
        return $user->canAccessCompany($plan->company) && $user->hasAnyRole(['super_admin', 'manager', 'technician']);
    }

    public function delete(User $user, MaintenancePlan $plan): bool
    {
        return $user->canAccessCompany($plan->company) && $user->hasAnyRole(['super_admin', 'manager']);
    }
}