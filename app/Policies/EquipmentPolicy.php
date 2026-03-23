<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Equipment;
use Illuminate\Auth\Access\HandlesAuthorization;

class EquipmentPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Equipment');
    }

    public function view(AuthUser $authUser, Equipment $equipment): bool
    {
        return $authUser->can('View:Equipment');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Equipment');
    }

    public function update(AuthUser $authUser, Equipment $equipment): bool
    {
        return $authUser->can('Update:Equipment');
    }

    public function delete(AuthUser $authUser, Equipment $equipment): bool
    {
        return $authUser->can('Delete:Equipment');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Equipment');
    }

    public function restore(AuthUser $authUser, Equipment $equipment): bool
    {
        return $authUser->can('Restore:Equipment');
    }

    public function forceDelete(AuthUser $authUser, Equipment $equipment): bool
    {
        return $authUser->can('ForceDelete:Equipment');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Equipment');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Equipment');
    }

    public function replicate(AuthUser $authUser, Equipment $equipment): bool
    {
        return $authUser->can('Replicate:Equipment');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Equipment');
    }

}