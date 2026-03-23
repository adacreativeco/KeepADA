<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\SparePart;
use Illuminate\Auth\Access\HandlesAuthorization;

class SparePartPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:SparePart');
    }

    public function view(AuthUser $authUser, SparePart $sparePart): bool
    {
        return $authUser->can('View:SparePart');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:SparePart');
    }

    public function update(AuthUser $authUser, SparePart $sparePart): bool
    {
        return $authUser->can('Update:SparePart');
    }

    public function delete(AuthUser $authUser, SparePart $sparePart): bool
    {
        return $authUser->can('Delete:SparePart');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:SparePart');
    }

    public function restore(AuthUser $authUser, SparePart $sparePart): bool
    {
        return $authUser->can('Restore:SparePart');
    }

    public function forceDelete(AuthUser $authUser, SparePart $sparePart): bool
    {
        return $authUser->can('ForceDelete:SparePart');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:SparePart');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:SparePart');
    }

    public function replicate(AuthUser $authUser, SparePart $sparePart): bool
    {
        return $authUser->can('Replicate:SparePart');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:SparePart');
    }

}