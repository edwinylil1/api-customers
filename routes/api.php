<?php

use App\Http\Controllers\Access\GeneralUserController;
use App\Http\Controllers\Access\RolController;
use App\Http\Controllers\Clients\ClientController;
use App\System\ApiCustomers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


if (ApiCustomers::userMaintenanceConfig()) {
    Route::middleware('auth:sanctum')
        ->resource('users', GeneralUserController::class)
        ->except('create', 'edit')
        ->names('users');
    Route::put('users-email/{user}', [GeneralUserController::class, 'updateEmail'])
        ->name('users-email.update');
    Route::put('users-password/{user}', [GeneralUserController::class, 'updatePassword'])
        ->name('users-password.update');
    Route::get('users-access/{user}', [GeneralUserController::class, 'generateApiKey'])
        ->name('users-access.token');
    Route::put('users-access/{user}', [GeneralUserController::class, 'updateAccess'])
        ->name('users-access.update');
}


if (ApiCustomers::permissionsConfig()) {
    Route::resource('groups', RolController::class)
        ->middleware('auth:sanctum')
        ->parameters(['groups' => 'role'])
        ->names('roles');
}

if (ApiCustomers::customerMasterConfig()) {
    Route::resource('customers', ClientController::class)
        ->middleware('auth:sanctum')
        ->parameters(['customers' => 'client'])
        ->except('create', 'edit')
        ->names('client');
    Route::post('customers-transfer', [ClientController::class, 'clientsTransfer'])
        ->middleware('auth:sanctum')
        ->name('client-transfer.store');
    Route::put('customers-transfer/{client}', [ClientController::class, 'clientsTransferUpdate'])
        ->middleware('auth:sanctum')
        ->name('client-transfer.update');
    Route::delete('customers-transfer/{client}', [ClientController::class, 'clientsTransferDestroy'])
        ->middleware('auth:sanctum')
        ->name('client-transfer.destroy');
    Route::patch('customers-status/{client}', [ClientController::class, 'statusUpdate'])
        ->middleware('auth:sanctum')
        ->name('client-status.update');
}

