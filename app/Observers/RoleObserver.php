<?php

namespace App\Observers;

use App\Models\Role;

class RoleObserver
{
    public function created(Role $role): void
    {
        cache()->forget('gate.permissions');
    }

    public function updated(Role $role): void
    {
        cache()->forget('gate.permissions');
    }

    public function deleted(Role $role): void
    {
        cache()->forget('gate.permissions');
    }

    public function restored(Role $role): void
    {
        cache()->forget('gate.permissions');
    }

    public function forceDeleted(Role $role): void
    {
        $role->permissions()->delete();
        cache()->forget('gate.permissions');
    }
}
