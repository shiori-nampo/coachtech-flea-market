<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

Route::get('/',[ProductController::class,'index'])->name('items.index');

Route::get('/products/{product}',[ProductController::class,'show'])->name('items.detail');


Route::get('/my-profile/edit', function() {
    return 'profile edit page';
})->name('profile.edit')->middleware('auth');


Route::post('/products/{product}/favorite',[ProductController::class,'toggleFavorite'])->name('products.toggleFavorite');