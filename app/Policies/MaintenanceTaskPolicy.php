<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MaintenanceTask;

class MaintenanceTaskPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, MaintenanceTask $task): bool
    {
        return $user->canAccessCompany($task->company);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'manager', 'technician']);
    }

    public function update(User $user, MaintenanceTask $task): bool
    {
        return $user->canAccessCompany($task->company) && $user->hasAnyRole(['super_admin', 'manager', 'technician']);
    }

    public function delete(User $user, MaintenanceTask $task): bool
    {
        return $user->canAccessCompany($task->company) && $user->hasAnyRole(['super_admin', 'manager']);
    }
}