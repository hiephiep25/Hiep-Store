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
Route::post('/forgot-password', [Admin\Auth\LoginController::class, 'forgotPassword']);
Route::post('/reset-password', [Admin\Auth\LoginController::class, 'resetPassword']);

Route::middleware('auth:sanctum', 'have-permission')->group(function () {
    Route::get('/profile', [Admin\ProfileController::class, 'profile']);
    Route::get('/logout', [Admin\Auth\LoginController::class, 'logout']);
    Route::post('/change-password', [Admin\ProfileController::class, 'updatePassword']);
    Route::post('/update-profile', [Admin\ProfileController::class, 'updateProfile']);
    Route::get('/products/categories', [Admin\ProductController::class, 'getCategories']);

    Route::middleware('check-role:ADMIN,MANAGER,STAFF')->group(function () {
        Route::prefix('stores')->group(function () {
            Route::get('/', [Admin\StoreController::class, 'getStores']);
        });
        Route::prefix('offline-orders')->group(function () {
            Route::get('/', [Admin\OfflineOrderController::class, 'index']);
            Route::get('/products', [Admin\OfflineOrderController::class, 'getStoreProducts']);
            Route::get('/{id}', [Admin\OfflineOrderController::class, 'getOfflineOrderDetail']);
        });
        Route::prefix('online-orders')->group(function () {
            Route::get('/', [Admin\OnlineOrderController::class, 'index']);
            Route::get('/{id}', [Admin\OnlineOrderController::class, 'getOnlineOrderDetail']);
        });
        Route::prefix('stores')->group(function () {
            Route::get('/products', [Admin\StoreController::class, 'getProductStores']);
        });
    });

    //admin router
    Route::middleware('check-role:ADMIN')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('/', [Admin\UserController::class, 'index']);
            Route::post('/create', [Admin\UserController::class, 'create']);
            Route::get('/{id}', [Admin\UserController::class, 'show']);
            Route::post('/{id}', [Admin\UserController::class, 'update']);
            Route::delete('{id}', [Admin\UserController::class, 'delete']);
        });
        Route::prefix('managers')->group(function () {
            Route::get('/', [Admin\ManagerController::class, 'index']);
            Route::get('/{id}', [Admin\ManagerController::class, 'show']);
            Route::post('/{id}', [Admin\ManagerController::class, 'update']);
        });
        Route::prefix('admin-stores')->group(function () {
            Route::get('/', [Admin\StoreController::class, 'index']);
            Route::post('/create', [Admin\StoreController::class, 'create']);
            Route::get('/{id}', [Admin\StoreController::class, 'show']);
            Route::post('/{id}', [Admin\StoreController::class, 'update']);
        });

        Route::post('/store-product', [Admin\StoreController::class, 'storeProduct']);

        Route::prefix('stores')->group(function () {
            Route::post('/create', [Admin\StoreController::class, 'create']);
            Route::get('/{id}', [Admin\StoreController::class, 'show']);
            Route::post('/{id}', [Admin\StoreController::class, 'update']);
            Route::delete('/{id}', [Admin\StoreController::class, 'delete']);
        });

        Route::prefix('categories')->group(function () {
            Route::get('/', [Admin\CategoryController::class, 'index']);
            Route::post('/create', [Admin\CategoryController::class, 'create']);
            Route::get('/{id}', [Admin\CategoryController::class, 'show']);
            Route::post('/{id}', [Admin\CategoryController::class, 'update']);
            Route::delete('/{id}', [Admin\CategoryController::class, 'delete']);
        });

        Route::prefix('process')->group(function () {
            Route::post('/create', [Admin\ProcessController::class, 'create']);
        });
    });

    // manager router
    Route::middleware('check-role:ADMIN,MANAGER')->group(function () {

        Route::prefix('staffs')->group(function () {
            Route::get('/', [Admin\StaffController::class, 'index']);
            Route::get('/{id}', [Admin\StaffController::class, 'show']);
            Route::post('/{id}', [Admin\StaffController::class, 'update']);
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
            Route::get('/available', [Admin\ProductController::class, 'getAvailable']);
            Route::get('/all-available', [Admin\ProductController::class, 'getAllAvailable']);
            Route::post('/create', [Admin\ProductController::class, 'create']);
            Route::get('/{id}', [Admin\ProductController::class, 'show']);
            Route::post('/{id}', [Admin\ProductController::class, 'update']);
            Route::delete('/{id}', [Admin\ProductController::class, 'delete']);
        });

        Route::prefix('documents')->group(function () {
            Route::get('/suppliers', [Admin\DocumentController::class, 'getSuppliers']);
            Route::get('/all', [Admin\DocumentController::class, 'getAllDocuments']);
            Route::get('/{id}', [Admin\DocumentController::class, 'show']);
            Route::post('/approve/{id}', [Admin\DocumentController::class, 'approve']);
            Route::post('/deny/{id}', [Admin\DocumentController::class, 'deny']);
        });

        Route::prefix('revenues')->group(function () {
            Route::get('/month', [Admin\OrderController::class, 'getRevenueByMonth']);
            Route::get('/online', [Admin\OrderController::class, 'getOnlineRevenueByMonth']);
            Route::get('/offline', [Admin\OrderController::class, 'getOfflineRevenueByMonth']);
        });

        Route::prefix('process')->group(function () {
            Route::get('/', [Admin\ProcessController::class, 'index']);
            Route::get('/{id}', [Admin\ProcessController::class, 'show']);
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

    Route::middleware('check-role:STAFF')->group(function () {
        Route::prefix('offline-orders')->group(function () {
            Route::post('/create', [Admin\OfflineOrderController::class, 'store']);
        });
    });

    Route::prefix('notifications')->group(function () {
        Route::get('/list-noti', [Admin\NotificationController::class, 'listNotification']);
        Route::put('/{id}/read', [Admin\NotificationController::class, 'readNotification']);
        Route::get('/unread-count', [Admin\NotificationController::class, 'countUnreadNotifications']);
    });
});
