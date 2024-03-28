<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Subsciptions\PlanController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'Subscriptions'], function(){
    Route::get('plans', [PlanController::class, 'index'])->name('subscriptions.plans');
    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.checkout');
});

// Route::group('namespace');
Route::get('/login', [AuthController::class, 'loginLayout']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', [AuthController::class, 'registerLayout']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
