<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/admin/{any?}', function () {
    return view('app');
})->where('any', '.*');

Route::get('/', [Web\HomeController::class, 'index']);
Route::get('/shop/product/{id}', [Web\ShopController::class, 'show']);
Route::get('/shop', [Web\ShopController::class, 'index']);
Route::get('/shop/{id}', [Web\ShopController::class, 'category']);

Route::get('/contact',[Web\ContactController::class, 'index']);

Route::prefix('cart')->group(function(){
    Route::get('add/{id}',[Web\CartController::class, 'add']);
    Route::get('/',[Web\CartController::class, 'index']);
    Route::get('delete/{rowId}',[Web\CartController::class, 'delete']);
    Route::get('/destroy',[Web\CartController::class, 'destroy']);
    Route::get('/update',[Web\CartController::class, 'update']);
});

Route::prefix('login')->group(function(){
    Route::get('/',[Web\LoginController::class, 'index']);
    Route::post('/',[Web\LoginController::class, 'checkLogin']);
    Route::get('/logout',[Web\LoginController::class, 'logout']);
});

Route::prefix('register')->group(function(){
    Route::get('/',[Web\RegisterController::class, 'index']);
    Route::post('/',[Web\RegisterController::class, 'register']);
});
