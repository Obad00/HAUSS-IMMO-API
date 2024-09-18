<?php

use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\LogementController;
use App\Http\Controllers\ReservationController;


Route::middleware('auth:api')->post('/users/{userId}/assign-role', [UsersController::class, 'assignRole']);


// Route pour afficher tous les logements sans connexion
Route::get('logements/public', [LogementController::class, 'publicIndex']);
// Route pour afficher les détails d'un logement spécifique sans connexion
Route::get('logements/public/{id}', [LogementController::class, 'publicShow']);
//Route pour les réservations
Route::apiResource('reservations', ReservationController::class);
//Route pour les categories
Route::apiResource('categories', CategorieController::class);


Route::middleware('auth:api')->group(function () {
    Route::apiResource('logements', LogementController::class);
});





Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:api')->post('logout', [AuthController::class, 'logout']);


Route::post('/reservations/{id}/archive', [ReservationController::class, 'archive'])
     ->middleware('auth:api'); // Assure-toi que l'utilisateur est authentifié

Route::post('/reservations/{id}/tenant-delete', [ReservationController::class, 'tenantDelete'])
     ->middleware('auth:api'); // Assure-toi que l'utilisateur est authentifié

Route::post('/reservations/{id}/owner-restore', [ReservationController::class, 'ownerRestore'])
     ->middleware('auth:api'); // Assure-toi que l'utilisateur est authentifié

Route::post('/reservations/{id}/tenant-restore', [ReservationController::class, 'tenantRestore'])
     ->middleware('auth:api'); // Assure-toi que l'utilisateur est authentifié

Route::delete('/reservations/{id}', [ReservationController::class, 'destroy'])
     ->middleware('auth:api'); // Assure-toi que l'utilisateur est authentifié


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Routes pour les roles
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


