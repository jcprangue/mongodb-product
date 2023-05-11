<?php

use App\Http\Controllers\ProductController;
use App\Jobs\Product\ProductsListener;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    // return Inertia::render('Welcome');
});
Route::resource('products',ProductController::class);
Route::get('products-chart',[ProductController::class,'chart'])->name('products.chart');

Route::get('/product-scrape', function () {
    ProductsListener::dispatch();
});

