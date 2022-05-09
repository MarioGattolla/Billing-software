<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DdtController;
use App\Http\Controllers\DdtRawController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceRawController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\UserController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('users', UserController::class)->middleware(['auth']);
Route::resource('companies', CompanyController::class)->middleware(['auth']);
Route::resource('products', ProductController::class)->middleware(['auth']);
Route::resource('categories', CategoryController::class)->middleware(['auth']);
Route::resource('invoices', InvoiceController::class)->middleware(['auth']);
Route::resource('dtts', DdtController::class)->middleware(['auth']);
Route::resource('orders', OrderController::class)->middleware(['auth']);
Route::resource('ddts/{id}/ddtRaws', DdtRawController::class)->middleware(['auth']);
Route::resource('invoices/{id}/invoiceRaws', InvoiceRawController::class)->middleware(['auth']);

Route::get('/orders/search', [OrderController::class , 'search'])->name('search_product');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
