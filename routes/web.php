<?php

use App\Http\Controllers\AddChartController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Spatie\FlareClient\View;

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

Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', function () {
    return view('pages.home.index');
})->name('home');

Route::get('/shop', function () {
    return view('pages.shop.index');
});

Route::get('/product/{id}', [ProductController::class, 'detail']);

Route::middleware(['auth'])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/', function () {
            return view('pages.dashboard.index');
        });

        Route::get('/category-product', function () {
            return view('pages.category-product.index');
        });

        Route::get('/product', function () {
            return view('pages.product.index');
        });

        Route::get('/product/add', function () {
            return view('pages.product.add');
        });

        Route::get('/product/edit/{id}', [ProductController::class, 'edit']);
    });
    Route::get('/cart', function () {
        return view('pages.cart.index');
    });
});
