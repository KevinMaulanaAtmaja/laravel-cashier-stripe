<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Plan\PlanController;
use App\Http\Controllers\Subscriptions\Account\SubsController;
use App\Http\Controllers\Subscriptions\SubscriptionController;
use App\Http\Controllers\Subscriptions\Account\AccountController;
use App\Http\Controllers\Subscriptions\Account\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('plans', [PlanController::class, 'index'])->name('subscriptions.plans');
    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.checkout');
    Route::post('subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');
});

Route::group(['middleware' => ['auth', 'notsubs']], function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account');
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::post('/checkout', [ProductController::class, 'checkout'])->name('checkout');
    Route::get('/success', [ProductController::class, 'success'])->name('checkout.success');
    Route::get('/cancel', [ProductController::class, 'cancel'])->name('checkout.cancel');
    Route::post('/webhook', [ProductController::class, 'webhook'])->name('checkout.webhook')->withoutMiddleware(['auth', 'notsubs']);
    Route::group(['prefix' => 'subscriptions'], function () {
        Route::get('/cancel', [SubsController::class, 'cancelIndex'])->name('account.subs');
        Route::post('/cancel', [SubsController::class, 'cancelStore'])->name('account.subs.cancel');

        Route::get('/resume', [SubsController::class, 'resumeIndex'])->name('account.resume');
        Route::post('/resume', [SubsController::class, 'resumeStore'])->name('account.resume.store');
    });
});

Route::group(['prefix' => 'auth'], function(){
    Route::get('/login', [AuthController::class, 'loginLayout'])->name('loginLayout')->middleware('isLogin');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

    Route::get('/register', [AuthController::class, 'registerLayout'])->name('registerLayout');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});
