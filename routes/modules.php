<?php

use App\Http\Controllers\Security\ModuleController;

Route::group(['prefix' => 'modules'], function() {
    Route::get('/', [\App\Services\ModuleManagementService::class, 'init']);

});
