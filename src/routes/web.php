<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProfileController;

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


Route::middleware('auth')->get('/verify', function () {
    return view('auth.verify');
})->name('verify');



Route::middleware('auth','verified')->group(function () {

    Route::post('/products/{product}/favorite',[ProductController::class,'toggleFavorite'])->name('products.toggleFavorite');

    Route::post('/products/{product}/comments',[CommentController::class,'store'])->name('comments.store');

    Route::get('/purchase/{product}', [PurchaseController::class,'show'])->name('purchase.show');

    Route::get('/purchase/{product}/payment',[PurchaseController::class,'showPayment'])->name('purchase.payment');

    Route::patch('/purchase/{product}/payment',[PurchaseController::class,'updatePayment'])->name('purchase.payment.update');

    Route::post('/purchase/{product}',[PurchaseController::class,'store'])->name('purchase.store');

    Route::get('/purchase/{product}/success',
    [PurchaseController::class,'success'])->name('purchase.success');

    Route::get('/purchase/{product}/address',[PurchaseController::class,'showAddressForm'])
    ->name('purchase.address');

    Route::post('/purchase/{product}/address',[PurchaseController::class,'updateAddress'])
    ->name('purchase.address.update');

    Route::get('/mypage',[ProfileController::class,'mypage'])
    ->name('mypage');

    Route::get('/mypage/profile',[ProfileController::class,'mypageProfile'])
    ->name('profile.edit');

    Route::post('/mypage/profile',[ProfileController::class,'update'])
    ->name('profile.update');

    Route::get('/sell',[ProductController::class,'create'])
    ->name('items.sell');

    Route::post('/sell',[ProductController::class,'store'])
    ->name('items.store');

});















