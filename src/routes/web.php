<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PaymentController;


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
Route::middleware(['auth', 'verified'])->group(function () {
    // マイページ関連
    Route::prefix('mypage')->group(function () {
        Route::get('/', [MypageController::class, 'index']);
        Route::get('/profile', [MypageController::class, 'profile']);
        Route::post('/profile/update', [MypageController::class, 'update']);
    });

    // 購入関連
    Route::prefix('purchase')->group(function (){
        Route::get('/{item_id}', [PurchaseController::class, 'index']);
        Route::post('/decide/{item_id}', [PurchaseController::class, 'decidePurchase']);         
        Route::get('/address/{item_id}', [PurchaseController::class, 'address']);  
        Route::post('/address/update/{item_id}', [PurchaseController::class, 'updateAddress']);
        Route::get('/payment/{item_id}', [PurchaseController::class, 'payment']);
        Route::post('/payment/select/{item_id}', [PurchaseController::class, 'selectPayment']);
        Route::get('/payment/create/{item_id}', [PaymentController::class, 'create'])->name('create');
        Route::post('/payment/store/{item_id}', [PaymentController::class, 'store'])->name('store');  
    });

    // 商品関連
    Route::prefix('item')->group(function (){
        Route::get('/comment/{item_id}', [ItemController::class, 'comment']);
        Route::post('/comment/store/{item_id}', [ItemController::class, 'store']);
        Route::delete('/comment/delete/{item_id}/{comment_id}',[ItemController::class, 'deleteComment']);
        Route::post('/like/{item_id}', [ItemController::class, 'like']);
        Route::delete('/unlike/{item_id}', [ItemController::class, 'unlike']);
    });

    // 出品関連
    Route::get('/sell', [SellController::class, 'index']);
    Route::get('/sell/{item_id}',[SellController::class, 'index']);
    Route::post('/sell',[SellController::class, 'create']);
    Route::post('/sell/{item_id}',[SellController::class, 'edit']);
});

// ログインしなくても可能
Route::get('/', [IndexController::class, 'index']);
Route::get('/item/{item_id}', [ItemController::class, 'show']);
Route::get('/search', [IndexController::class, 'search']);