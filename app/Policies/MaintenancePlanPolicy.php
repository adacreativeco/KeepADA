<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\MaintenancePlan;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaintenancePlanPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:MaintenancePlan');
    }

    public function view(AuthUser $authUser, MaintenancePlan $maintenancePlan): bool
    {
        return $authUser->can('View:MaintenancePlan');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:MaintenancePlan');
    }

    public function update(AuthUser $authUser, MaintenancePlan $maintenancePlan): bool
    {
        return $authUser->can('Update:MaintenancePlan');
    }

    public function delete(AuthUser $authUser, MaintenancePlan $maintenancePlan): bool
    {
        return $authUser->can('Delete:MaintenancePlan');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:MaintenancePlan');
    }

    public function restore(AuthUser $authUser, MaintenancePlan $maintenancePlan): bool
    {
        return $authUser->can('Restore:MaintenancePlan');
    }

    public function forceDelete(AuthUser $authUser, MaintenancePlan $maintenancePlan): bool
    {
        return $authUser->can('ForceDelete:MaintenancePlan');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:MaintenancePlan');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:MaintenancePlan');
    }

    public function replicate(AuthUser $authUser, MaintenancePlan $maintenancePlan): bool
    {
        return $authUser->can('Replicate:MaintenancePlan');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:MaintenancePlan');
    }

}