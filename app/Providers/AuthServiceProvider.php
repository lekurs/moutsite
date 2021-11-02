<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Role;
use App\Models\User;
use DateTimeImmutable;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerPermissionGates();
        //
    }

    private function registerPermissionGates(): void
    {
        $permissions = cache()->remember('gate.permissions', new DateTimeImmutable('+1 week'), function () {
            $roles = Role::with('permissions')->get();
            $permissions = [];

            foreach ($roles as $role) {
                foreach($role->permissions as $permission) {
                    $permissions[$permission->key][] = $role->id;
                }
            }

            return $permissions;
        });
        foreach ($permissions as $key => $permission) {
            Gate::define($key, function(User $user) use($key) {
                return $user->hasPermission($key);
            });
        }
    }
}
