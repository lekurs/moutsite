<?php

namespace App\Traits;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

trait HasRole
{
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'roles_users');
    }

    public function hasRole(Collection $roles): bool
    {
        return (bool) $roles->intersect($this->roles)->count();
    }

    public function hasPermission($permission): bool
    {
        $find = Permission::where('key', $permission)->first();

        if ($find) {
            return $this->hasRole($find->roles);
        }
    }
}
