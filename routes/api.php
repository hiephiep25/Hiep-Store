<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;

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

Route::get('verify', [Admin\Auth\LoginController::class, 'verify']);
Route::post('login', [Admin\Auth\LoginController::class, 'login']);

Route::middleware('auth:sanctum', 'have-permission')->group(function () {
    Route::get('/profile', [Admin\ProfileController::class, 'profile']);
    Route::get('/logout', [Admin\Auth\LoginController::class, 'logout']);
    Route::post('/change-password', [Admin\ProfileController::class, 'updatePassword']);
    Route::post('/update-profile', [Admin\ProfileController::class, 'updateProfile']);
    Route::get('/products/categories', [Admin\ProductController::class, 'getCategories']);

    //admin router
    Route::middleware('check-role:ADMIN')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/', [Admin\UserController::class, 'index']);
            Route::post('/create', [Admin\UserController::class, 'create']);
            Route::get('/{id}', [Admin\UserController::class, 'show']);
            Route::post('/{id}', [Admin\UserController::class, 'update']);
            Route::delete('{id}', [Admin\UserController::class, 'delete']);
        });
    });

    // manager router
    Route::middleware('check-role:MANAGER')->group(function () {
        Route::prefix('categories')->group(function () {
            Route::get('/', [Admin\CategoryController::class, 'index']);
            Route::post('/create', [Admin\CategoryController::class, 'create']);
            Route::get('/{id}', [Admin\CategoryController::class, 'show']);
            Route::post('/{id}', [Admin\CategoryController::class, 'update']);
            Route::delete('/{id}', [Admin\CategoryController::class, 'delete']);
        });

        Route::prefix('discounts')->group(function () {
            Route::get('/', [Admin\DiscountController::class, 'index']);
            Route::post('/create', [Admin\DiscountController::class, 'create']);
            Route::get('/{id}', [Admin\DiscountController::class, 'show']);
            Route::post('/{id}', [Admin\DiscountController::class, 'update']);
            Route::delete('/{id}', [Admin\DiscountController::class, 'delete']);
        });

        Route::prefix('products')->group(function () {
            Route::get('/', [Admin\ProductController::class, 'index']);
            Route::post('/create', [Admin\ProductController::class, 'create']);
            Route::get('/{id}', [Admin\ProductController::class, 'show']);
            Route::post('/{id}', [Admin\ProductController::class, 'update']);
            Route::delete('/{id}', [Admin\ProductController::class, 'delete']);
        });

        Route::prefix('stores')->group(function () {
            Route::get('/', [Admin\StoreController::class, 'getStores']);
            Route::post('/store', [Admin\StoreController::class, 'store']);
        });

        Route::prefix('documents')->group(function () {
            Route::get('/suppliers', [Admin\DocumentController::class, 'getSuppliers']);
            Route::get('/all', [Admin\DocumentController::class, 'getAllDocuments']);
            Route::get('/{id}', [Admin\DocumentController::class, 'show']);
            Route::post('/approve/{id}', [Admin\DocumentController::class, 'approve']);
            Route::post('/deny/{id}', [Admin\DocumentController::class, 'deny']);
        });
    });

    // supplier-route
    Route::middleware('check-role:SUPPLIER')->group(function () {
        Route::prefix('documents')->group(function () {
            Route::get('/', [Admin\DocumentController::class, 'getMyDocuments']);
            Route::get('/my/{id}', [Admin\DocumentController::class, 'showMyDocuments']);
            Route::post('/create', [Admin\DocumentController::class, 'create']);
            Route::post('/{id}', [Admin\DocumentController::class, 'update']);
            Route::delete('/{id}', [Admin\DocumentController::class, 'delete']);
        });
    });

    Route::middleware('check-role:MANAGER,STAFF')->group(function () {
        Route::prefix('offline-orders')->group(function () {
            Route::get('/', [Admin\OfflineOrderController::class, 'index']);
            Route::get('/store-product/{store}', [Admin\OfflineOrderController::class, 'getStoreProducts']);
            Route::post('/{store}/create', [Admin\OfflineOrderController::class, 'store']);
            Route::get('/{id}', [Admin\OfflineOrderController::class, 'getOfflineOrderDetail']);
        });
    });

    Route::prefix('notifications')->group(function () {
        Route::get('/list-noti', [Admin\NotificationController::class, 'listNotification']);
        Route::put('/{id}/read', [Admin\NotificationController::class, 'readNotification']);
        Route::get('/unread-count', [Admin\NotificationController::class, 'countUnreadNotifications']);
    });

    Route::prefix('revenues')->group(function () {
        Route::get('/month', [Admin\OrderController::class, 'getRevenueByMonth']);
    });
});
