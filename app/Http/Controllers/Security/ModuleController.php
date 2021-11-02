<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Repository\ModuleRepository;
use App\Repository\PermissionRepository;
use App\Services\ModuleManagementService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class ModuleController extends Controller
{

    public function __construct(
        private ModuleRepository $moduleRepository,
        private PermissionRepository $permissionRepository
    )
    { }


    public function index()
    {
        try {
            $this->authorize('admin.modules.index');
            $modules = $this->moduleRepository->getAll();

            return view('pages.admin.security.modules.index', [
                'modules' => $modules
            ]);
        } catch (AuthorizationException) {
            Log::info('Attempted access violation', [auth()->user(), request()]);

            abort(403);
        }
    }

    public function show()
    {

    }

    public function edit()
    {

    }

    public function update()
    {

    }

    public function store()
    {

    }

    public function destroy()
    {

    }
}
