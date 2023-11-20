<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;

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

Route::get('verify', [LoginController::class, 'verify']);
Route::post('login', [LoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [UserController::class, 'profile']);
    Route::get('/logout', [LoginController::class, 'logout']);
    Route::post('/change-password', [ProfileController::class, 'updatePassword']);

    //admin router
    Route::middleware('check-role:admin')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users/create', [UserController::class, 'create']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::post('/users/{id}', [UserController::class, 'update']);
        Route::delete('users/{id}', [UserController::class, 'delete']);
    });
});
