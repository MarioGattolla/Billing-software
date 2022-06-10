<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DdtController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SearchCompanyController;
use App\Http\Controllers\SearchOrderController;
use App\Http\Controllers\SearchProductController;
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

Route::get('/test', function () {

    return view('Fabio.Fabio Folder.test');

});

Route::resource('users', UserController::class)->middleware(['auth']);
Route::resource('companies', CompanyController::class)->middleware(['auth']);
Route::resource('products', ProductController::class)->middleware(['auth']);
Route::get('/old/products', [ProductController::class, 'old_index'])->name('old.products.index');
Route::get('/old/orders/create', [OrderController::class, 'old_create'])->name('old.orders.create');

Route::resource('categories', CategoryController::class)->middleware(['auth']);
Route::resource('invoices', InvoiceController::class)->middleware(['auth']);
Route::resource('ddts', DdtController::class)->middleware(['auth']);
Route::resource('orders', OrderController::class)->middleware(['auth']);

Route::get('/search/product', [SearchProductController::class, 'search_products']);
Route::get('/search/product_with_available_stock', [SearchProductController::class, 'search_products_with_available_stock']);
Route::get('/search/product_by_company', [SearchProductController::class, 'search_products_by_company']);
Route::get('/search/product_by_company_filtered', [SearchProductController::class, 'search_products_by_company_filtered']);


Route::get('/search/company/all', [SearchCompanyController::class, 'search_companies_privates']);
Route::get('/search/company/companies', [SearchCompanyController::class, 'search_companies']);

Route::get('/search/company_with_orders', [SearchCompanyController::class, 'search_company_with_orders']);

Route::get('/search/orders_by_company', [SearchOrderController::class, 'search_orders_by_company']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
