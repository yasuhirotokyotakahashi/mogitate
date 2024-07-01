<?php

use App\Http\Controllers\ProductController;
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

Route::get('/products/create', [ProductController::class, 'create'])->name('products.create'); // 商品登録フォーム表示
Route::post('/products/register', [ProductController::class, 'store'])->name('products.store');     // 商品登録

Route::get('/products', [ProductController::class, 'index'])->name('products.index');       // 商品一覧表示
Route::get('/products/{product_id}', [ProductController::class, 'show'])->name('products.show'); // 店舗詳細
Route::get('/products/{product_id}/edit', [ProductController::class, 'edit'])->name('products.edit'); // 商品更新フォーム表示
Route::put('/products/{product_id}/update', [ProductController::class, 'update'])->name('products.update');

Route::post('/products/search', [ProductController::class, 'search'])->name('products.search'); // 商品検索
Route::delete('/products/{product_id}/delete', [ProductController::class, 'destroy'])->name('products.destroy'); // 商品削除
