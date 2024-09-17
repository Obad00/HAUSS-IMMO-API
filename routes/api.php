<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AuthController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/roles', [RoleController::class, 'index']);
Route::post('/roles', [RoleController::class, 'store']);
Route::get('/roles/{id}', [RoleController::class, 'show']);
Route::put('/roles/{id}', [RoleController::class, 'update']);
Route::delete('/roles/{id}', [RoleController::class, 'destroy']);

// Routes pour les permissions
Route::get('/permissions', [PermissionController::class, 'index']);
Route::post('/permissions', [PermissionController::class, 'store']);
Route::get('/permissions/{id}', [PermissionController::class, 'show']);
Route::put('/permissions/{id}', [PermissionController::class, 'update']);
Route::delete('/permissions/{id}', [PermissionController::class, 'destroy']);

Route::middleware('auth:sanctum')->group(function () {
    // Routes pour les rôles
    // Route::get('/roles', [RoleController::class, 'index']);
    // Route::post('/roles', [RoleController::class, 'store']);
    // Route::get('/roles/{id}', [RoleController::class, 'show']);
    // Route::put('/roles/{id}', [RoleController::class, 'update']);
    // Route::delete('/roles/{id}', [RoleController::class, 'destroy']);

    // // Routes pour les permissions
    // Route::get('/permissions', [PermissionController::class, 'index']);
    // Route::post('/permissions', [PermissionController::class, 'store']);
    // Route::get('/permissions/{id}', [PermissionController::class, 'show']);
    // Route::put('/permissions/{id}', [PermissionController::class, 'update']);
    // Route::delete('/permissions/{id}', [PermissionController::class, 'destroy']);
});
