<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ProductController;

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
        Route::prefix('users')->group(function () {
            Route::get('/', [UserController::class, 'index']);
            Route::post('/create', [UserController::class, 'create']);
            Route::get('/{id}', [UserController::class, 'show']);
            Route::post('/{id}', [UserController::class, 'update']);
            Route::delete('{id}', [UserController::class, 'delete']);
        });
    });

    // manager router
    Route::middleware('check-role:MANAGER')->group(function () {
        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoryController::class, 'index']);
            Route::post('/create', [CategoryController::class, 'create']);
            Route::get('/{id}', [CategoryController::class, 'show']);
            Route::post('/{id}', [CategoryController::class, 'update']);
            Route::delete('/{id}', [CategoryController::class, 'delete']);
        });

        Route::prefix('discounts')->group(function () {
            Route::get('/', [DiscountController::class, 'index']);
            Route::post('/create', [DiscountController::class, 'create']);
            Route::get('/{id}', [DiscountController::class, 'show']);
            Route::post('/{id}', [DiscountController::class, 'update']);
            Route::delete('/{id}', [DiscountController::class, 'delete']);
        });

        Route::prefix('products')->group(function () {
            Route::get('/', [ProductController::class, 'index']);
            Route::get('/categories', [ProductController::class, 'getCategories']);
            Route::post('/create', [ProductController::class, 'create']);
            Route::get('/{id}', [ProductController::class, 'show']);
            Route::post('/{id}', [ProductController::class, 'update']);
            Route::delete('/{id}', [ProductController::class, 'delete']);
        });
    });
});
