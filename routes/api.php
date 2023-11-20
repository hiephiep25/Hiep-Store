<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;

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

Route::middleware('auth:sanctum', 'have-permission')->group(function () {
    Route::get('/profile', [UserController::class, 'profile']);
    Route::get('/logout', [LoginController::class, 'logout']);
    Route::post('/change-password', [ProfileController::class, 'updatePassword']);

    //admin router
    Route::middleware('check-role:ADMIN')->group(function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users/create', [UserController::class, 'create']);
        Route::get('/users/{id}', [UserController::class, 'show']);
        Route::post('/users/{id}', [UserController::class, 'update']);
        Route::delete('users/{id}', [UserController::class, 'delete']);
    });

    // manager router
    Route::middleware('check-role:MANAGER')->group(function () {
        Route::get('/categories', [CategoryController::class, 'index']);
        Route::post('/categories/create', [CategoryController::class, 'create']);
        Route::get('/categories/{id}', [CategoryController::class, 'show']);
        Route::post('/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('categories/{id}', [CategoryController::class, 'delete']);
    });
});
