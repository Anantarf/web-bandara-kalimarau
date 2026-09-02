<?php

namespace App\Policies;

use App\Models\PpidDocument;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PpidDocumentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->can('view_any_ppid::document');
    }

    public function view(User $user, PpidDocument $ppidDocument): bool
    {
        return $user->can('view_ppid::document');
    }

    public function create(User $user): bool
    {
        return $user->can('create_ppid::document');
    }

    public function update(User $user, PpidDocument $ppidDocument): bool
    {
        return $user->can('update_ppid::document');
    }

    public function delete(User $user, PpidDocument $ppidDocument): bool
    {
        return $user->can('delete_ppid::document');
    }

    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_ppid::document');
    }

    public function forceDelete(User $user, PpidDocument $ppidDocument): bool
    {
        return $user->can('force_delete_ppid::document');
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_ppid::document');
    }

    public function restore(User $user, PpidDocument $ppidDocument): bool
    {
        return $user->can('restore_ppid::document');
    }

    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_ppid::document');
    }

    public function replicate(User $user, PpidDocument $ppidDocument): bool
    {
        return $user->can('replicate_ppid::document');
    }

    public function reorder(User $user): bool
    {
        return $user->can('reorder_ppid::document');
    }
}
