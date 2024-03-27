<?php

use App\Http\Controllers\Subsciptions\PlanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'Subscriptions'], function(){
    Route::get('plans', [PlanController::class, 'index'])->name('plans');
});
