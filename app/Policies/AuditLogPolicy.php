<?php

namespace App\Policies;

use App\Models\AuditLog;
use App\Models\User;

class AuditLogPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_audit::log');
    }

    public function view(User $user, AuditLog $auditLog): bool
    {
        return $user->can('view_audit::log');
    }
}
