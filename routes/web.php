<?php

use App\Http\Controllers\Account\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Subscriptions\Account\SubsController;
use App\Http\Controllers\Subscriptions\PlanController;
use App\Http\Controllers\Subscriptions\SubscriptionController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('plans', [PlanController::class, 'index'])->name('subscriptions.plans');
    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.checkout');
    Route::post('subscriptions', [SubscriptionController::class, 'store'])->name('subscriptions.store');
});

Route::group(['middleware' => ['auth', 'notsubs'], 'prefix' => 'account'], function () {
    Route::get('account', [AccountController::class, 'index'])->name('account');
    Route::group(['namespace' => 'Subscriptions', 'prefix' => 'subscriptions'], function () {
        Route::get('/cancel', [SubsController::class, 'index'])->name('account.subs');
        Route::post('/cancel', [SubsController::class, 'cancel'])->name('account.subs.cancel');

        Route::get('/resume', [SubsController::class, 'resumeIndex'])->name('account.resume');
        Route::post('/resume', [SubsController::class, 'resumeStore'])->name('account.resume.store');
    });
});


Route::get('/login', [AuthController::class, 'loginLayout']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'registerLayout']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
