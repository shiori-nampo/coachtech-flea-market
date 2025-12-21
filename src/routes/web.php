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

Route::get('/register',function() {
    return view('auth.register');
})->name('register');

Route::get('/login',function() {
    return view('auth.login');
})->name('login');


Route::get('/auth-check',function() {
    return 'ログイン成功';
})->middleware('auth');