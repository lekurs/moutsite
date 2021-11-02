<?php

use App\Http\Controllers\API\invoices\InvoicesAPIController;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/client/{id}/contacts', function ($id) {

   return User::whereClientId($id)->get();
});

Route::get('/factures/annee', [InvoicesAPIController::class, 'show'])->name('invoices.api.show');
