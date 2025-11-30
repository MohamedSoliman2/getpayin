<?php

use App\Http\Controllers\HoldController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/products/{id}', [ProductController::class,'show']);
Route::post('/holds',[HoldController::class,'create']);
Route::post('/orders',[OrderController::class,'create']);
Route::post('/payments/webhook',[PaymentController::class,'webhook']);
