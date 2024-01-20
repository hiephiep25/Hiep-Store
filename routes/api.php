<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\OfflineOrderController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;

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
    Route::get('/profile', [ProfileController::class, 'profile']);
    Route::get('/logout', [LoginController::class, 'logout']);
    Route::post('/change-password', [ProfileController::class, 'updatePassword']);
    Route::post('/update-profile', [ProfileController::class, 'updateProfile']);
    Route::get('/products/categories', [ProductController::class, 'getCategories']);

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
            Route::post('/create', [ProductController::class, 'create']);
            Route::get('/{id}', [ProductController::class, 'show']);
            Route::post('/{id}', [ProductController::class, 'update']);
            Route::delete('/{id}', [ProductController::class, 'delete']);
        });

        Route::prefix('storages')->group(function () {
            Route::get('/', [StorageController::class, 'getStorages']);
            Route::post('/store', [StorageController::class, 'store']);
        });

        Route::prefix('documents')->group(function () {
            Route::get('/suppliers', [DocumentController::class, 'getSuppliers']);
            Route::get('/all', [DocumentController::class, 'getAllDocuments']);
            Route::get('/{id}', [DocumentController::class, 'show']);
            Route::post('/approve/{id}', [DocumentController::class, 'approve']);
            Route::post('/deny/{id}', [DocumentController::class, 'deny']);
        });
    });

    // supplier-route
    Route::middleware('check-role:SUPPLIER')->group(function () {
        Route::prefix('documents')->group(function () {
            Route::get('/', [DocumentController::class, 'getMyDocuments']);
            Route::get('/my/{id}', [DocumentController::class, 'showMyDocuments']);
            Route::post('/create', [DocumentController::class, 'create']);
            Route::post('/{id}', [DocumentController::class, 'update']);
            Route::delete('/{id}', [DocumentController::class, 'delete']);
        });
    });

    Route::middleware('check-role:MANAGER,STAFF')->group(function () {
        Route::prefix('offline-orders')->group(function () {
            Route::get('/', [OfflineOrderController::class, 'index']);
            Route::get('/storage-product/{storage}', [OfflineOrderController::class, 'getStorageProducts']);
            Route::post('/{storage}/create', [OfflineOrderController::class, 'store']);
            Route::get('/{id}', [OfflineOrderController::class, 'getOfflineOrderDetail']);
        });
    });

    Route::prefix('notifications')->group(function () {
        Route::get('/list-noti', [NotificationController::class, 'listNotification']);
        Route::put('/{id}/read', [NotificationController::class, 'readNotification']);
        Route::get('/unread-count', [NotificationController::class, 'countUnreadNotifications']);
    });

    Route::prefix('revenues')->group(function () {
        Route::get('/month', [OrderController::class, 'getRevenueByMonth']);
    });
});
