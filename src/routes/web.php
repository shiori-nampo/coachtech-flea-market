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

Route::get('/item/{item_id}',[ProductController::class,'show'])->name('items.detail');


Route::middleware('auth')->get('/verify', function () {
    return view('auth.verify');
})->name('verify');



Route::middleware('auth','verified')->group(function () {

    Route::post('/item/favorite/{item_id}',[ProductController::class,'toggleFavorite'])->name('items.toggleFavorite');

    Route::post('/item/comments/{item_id}',[CommentController::class,'store'])->name('comments.store');

    Route::get('/purchase/{item_id}', [PurchaseController::class,'show'])->name('purchase.show');

    Route::get('/purchase/payment/{item_id}',[PurchaseController::class,'showPayment'])->name('purchase.payment');

    Route::patch('/purchase/payment/{item_id}',[PurchaseController::class,'updatePayment'])->name('purchase.payment.update');

    Route::post('/purchase/{item_id}',[PurchaseController::class,'store'])->name('purchase.store');

    Route::get('/purchase/success/{item_id}',
    [PurchaseController::class,'success'])->name('purchase.success');

    Route::get('/purchase/address/{item_id}',[PurchaseController::class,'showAddressForm'])
    ->name('purchase.address');

    Route::post('/purchase/address/{item_id}',[PurchaseController::class,'updateAddress'])
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















