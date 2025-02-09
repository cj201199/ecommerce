<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ProductController::class, 'index'])->name('/');
Route::get('/product-search',[ProductController::class, 'search'])->name('product-search');
Route::get('/price-filter',[ProductController::class, 'price'])->name('price-filter');
Route::get('/rating-filter',[ProductController::class, 'rating'])->name('rating-filter');

Route::controller(CartController::class)->group(function(){
    Route::post('/cart-add','add')->name('cart-add');
    Route::get('cart-index','index')->name('cart-index');
    Route::post('/cart-remove','delete')->name('cart-remove');
    Route::post('/add-order','addOrder')->name('add-order');
});
