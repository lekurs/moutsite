<?php

namespace App\Services;

use App\Repository\ModuleRepository;
use App\Repository\PermissionRepository;
use Illuminate\Support\Facades\File;

class ModuleManagementService
{
    public function __construct(
//        private PermissionRepository $permissionRepository,
//        private ModuleRepository $moduleRepository

    ) { }

    /**
     * @param $modelInstance
     * @return bool
     */


    /**
     *
     */
    public function init()
    {
        \Artisan::call('modules:init');

        return response()->json();
    }
}
