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
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [ProductController::class, 'getListCart'])->name('cart.list');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');
// In routes/web.php
Route::delete('/cart/remove/{id}', [ProductController::class, 'removeProduct'])->name('cart.remove');
Route::delete('/cart/delete/{id}', [ProductController::class, 'removeProduct'])->name('cart.delete');

Route::post('/cart/delete/{productId}', [CartController::class, 'deleteProductQuantity'])->name('cart.deleteQuantity');


