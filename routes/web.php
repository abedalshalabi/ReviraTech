<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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

// Language routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/products/{slug}', [HomeController::class, 'product'])->name('product.show');
Route::get('/news', [HomeController::class, 'news'])->name('news');
Route::get('/news/{slug}', [HomeController::class, 'newsShow'])->name('news.show');
Route::get('/agents', [HomeController::class, 'agents'])->name('agents');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Admin panel is now handled by Filament at /admin

// Language specific routes
Route::group(['prefix' => '{locale}', 'where' => ['locale' => '[a-z]{2}']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.locale');
    Route::get('/products', [HomeController::class, 'products'])->name('products.locale');
    Route::get('/products/{slug}', [HomeController::class, 'product'])->name('product.show.locale');
    Route::get('/news', [HomeController::class, 'news'])->name('news.locale');
    Route::get('/news/{slug}', [HomeController::class, 'newsShow'])->name('news.show.locale');
    Route::get('/agents', [HomeController::class, 'agents'])->name('agents.locale');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact.locale');
    Route::get('/about', [HomeController::class, 'about'])->name('about.locale');
});
