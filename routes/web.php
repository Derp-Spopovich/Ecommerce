<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\RatingsController;

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
Route::middleware('auth')->group(function () { //authenticate, need the user to login to perform some actions

    //admin panel



Route::put('user/{user}/update', [UsersController::class, 'userUpdate'])->name('admin.update');
Route::put('product/{product}/update', [UsersController::class, 'productUpdate'])->name('admin.update_product');
Route::get('/admin/{product}/edit', [UsersController::class, 'ProductEdit'])->name('admin.edit_product');
Route::get('/{user}/edit', [UsersController::class, 'UserEdit'])->name('admin.edit_user');
Route::get('/admin/products', [UsersController::class, 'indexProducts'])->name('admin.index_products');
Route::delete('product/{product}/delete', [UsersController::class, 'productDestroy'])->name('admin.delete_product');
Route::delete('user/{user}/delete', [UsersController::class, 'destroy'])->name('admin.delete');
Route::get('/admin/users', [UsersController::class, 'index'])->name('admin.index_users');

Route::get('/payment/{product}', [PaymentsController::class, 'create'])->name('payments.create')->middleware('can:create,product');
Route::post('/payment/{product}', [PaymentsController::class, 'store'])->name('payments.store');
Route::get('/ordered/{user}', [PaymentsController::class, 'index'])->name('payments.index');
Route::get('/orders/{user}', [PaymentsController::class, 'show'])->name('payments.show');

Route::post('/cart/{product}', [CartsController::class, 'store'])->name('carts.store');
Route::get('/cart/{user}', [CartsController::class, 'show'])->name('carts.show');

Route::get('/products/create', [ProductsController::class, 'create'])->name('products.create');
Route::get('/products/{product}/edit', [ProductsController::class, 'edit'])->name('products.edit')->middleware('can:update,product');
Route::put('/products/{product}', [ProductsController::class, 'update'])->name('products.update')->middleware('can:update,product');
Route::delete('/product/{product}', [ProductsController::class, 'destroy'])->name('products.destroy')->middleware('can:update,product');
Route::post('/products', [ProductsController::class, 'store'])->name('products.store');

Route::post('/rating/{product}', [RatingsController::class, 'store'])->name('ratings.store');
Route::delete('/rating/{rating}', [RatingsController::class, 'destroy'])->name('ratings.destroy');

Route::get('/user/{user}', [UsersController::class, 'edit'])->name('users.edit');
Route::get('/users/{user}', [UsersController::class, 'show'])->name('users.show');
Route::put('/user/{user}', [UsersController::class, 'update'])->name('users.update');



}); //end of authentication

Route::get('/products/{product}', [ProductsController::class, 'show'])->name('products.show');
Route::get('/', [ProductsController::class, 'index'])->name('products.index');
Route::get('/search', [ProductsController::class, 'search'])->name('products.search');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');