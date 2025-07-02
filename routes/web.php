<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminPedidosController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

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

// Rutas públicas
Route::get('/', 'App\Http\Controllers\HomeController@index')->name("home.index");
Route::get('/about', 'App\Http\Controllers\HomeController@about')->name("home.about");
Route::get('/products', 'App\Http\Controllers\ProductController@index')->name("product.index");
Route::get('/products/{id}', 'App\Http\Controllers\ProductController@show')->name("product.show");
Route::get('/load-more-products', 'App\Http\Controllers\ProductController@loadMoreProducts');

// Rutas del carrito
Route::get('/cart', 'App\Http\Controllers\CartController@index')->name("cart.index");
Route::get('/cart/delete', 'App\Http\Controllers\CartController@delete')->name("cart.delete");
Route::post('/cart/add/{id}', 'App\Http\Controllers\CartController@add')->name("cart.add");

// Rutas de autenticación y perfil
Route::middleware('auth')->group(function () {
    Route::get('/perfil', 'App\Http\Controllers\MyAccountController@showProfile')->name('perfil');
    Route::post('/perfil/anadirFondos', 'App\Http\Controllers\MyAccountController@anadirFondos')->name('perfil.anadirFondos');
    Route::post('/perfil/actualizar-foto', 'App\Http\Controllers\MyAccountController@actualizarFoto')->name('perfil.actualizarFoto');
    Route::get('/my-account/orders', 'App\Http\Controllers\MyAccountController@orders')->name("myaccount.orders");
    Route::get('/cart/purchase', 'App\Http\Controllers\CartController@purchase')->name("cart.purchase");
});

// Rutas del admin
Route::middleware('admin')->group(function () {
    Route::get('/admin', 'App\Http\Controllers\Admin\AdminHomeController@index')->name("admin.home.index");
    Route::get('/admin/products', 'App\Http\Controllers\Admin\AdminProductController@index')->name("admin.product.index");
    Route::post('/admin/products/store', 'App\Http\Controllers\Admin\AdminProductController@store')->name("admin.product.store");
    Route::get('/admin/products/{id}/edit', 'App\Http\Controllers\Admin\AdminProductController@edit')->name("admin.product.edit");
    Route::put('/admin/products/{id}/update', 'App\Http\Controllers\Admin\AdminProductController@update')->name("admin.product.update");
    Route::delete('/admin/products/{id}/delete', 'App\Http\Controllers\Admin\AdminProductController@delete')->name("admin.product.delete");
    Route::get('/admin/pedidos', 'App\Http\Controllers\Admin\AdminPedidosController@index')->name('admin.pedidos.index');
    Route::get('/admin/pedidos/{id}', 'App\Http\Controllers\Admin\AdminPedidosController@show')->name('admin.pedidos.show');
});

// Rutas de reseñas
Route::post('/product/{productId}/reviews', 'App\Http\Controllers\ReviewController@store')->name('reviews.store');
Route::get('/product/{productId}/reviews', 'App\Http\Controllers\ReviewController@index')->name('reviews.show');

// Ruta de Backup en el panel de administración
Route::middleware('admin')->prefix('admin/backup')->name('admin.backup.')->group(function () {
    Route::get('/', 'App\Http\Controllers\BackupController@index')->name('index');
    Route::post('/create', 'App\Http\Controllers\BackupController@create')->name('create');
    Route::get('/download/{filename}', 'App\Http\Controllers\BackupController@download')->name('download');
    Route::delete('/delete/{filename}', 'App\Http\Controllers\BackupController@delete')->name('delete');
    Route::post('/restore/{filename}', 'App\Http\Controllers\BackupController@restore')->name('restore');
});



Auth::routes();
