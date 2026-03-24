<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\EquipmentApiController;
use App\Http\Controllers\Api\MaintenanceTaskApiController;

Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Equipment Endpoints
    Route::get('/equipment', [EquipmentApiController::class, 'index']);
    Route::get('/equipment/{id}', [EquipmentApiController::class, 'show']);

    // Maintenance Task Endpoints
    Route::get('/tasks', [MaintenanceTaskApiController::class, 'index']);
    Route::get('/tasks/{id}', [MaintenanceTaskApiController::class, 'show']);
    Route::post('/tasks/{id}/status', [MaintenanceTaskApiController::class, 'updateStatus']);
});
