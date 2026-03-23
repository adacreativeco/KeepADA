<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MaintenanceTask;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaintenanceTaskPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MaintenanceTask');
    }

    public function view(AuthUser $authUser, MaintenanceTask $maintenanceTask): bool
    {
        return $authUser->can('View:MaintenanceTask');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MaintenanceTask');
    }

    public function update(AuthUser $authUser, MaintenanceTask $maintenanceTask): bool
    {
        return $authUser->can('Update:MaintenanceTask');
    }

    public function delete(AuthUser $authUser, MaintenanceTask $maintenanceTask): bool
    {
        return $authUser->can('Delete:MaintenanceTask');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:MaintenanceTask');
    }

    public function restore(AuthUser $authUser, MaintenanceTask $maintenanceTask): bool
    {
        return $authUser->can('Restore:MaintenanceTask');
    }

    public function forceDelete(AuthUser $authUser, MaintenanceTask $maintenanceTask): bool
    {
        return $authUser->can('ForceDelete:MaintenanceTask');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MaintenanceTask');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MaintenanceTask');
    }

    public function replicate(AuthUser $authUser, MaintenanceTask $maintenanceTask): bool
    {
        return $authUser->can('Replicate:MaintenanceTask');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MaintenanceTask');
    }

}