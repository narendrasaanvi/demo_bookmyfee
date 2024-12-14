<?php

use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ApiController;
use App\Http\Controllers\API\SalesController;

use App\Http\Controllers\PaymentController;


// Login route
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


Route::get('/tournament-list', [ApiController::class, 'tournamentList']);
Route::post('/payment/callback', [PaymentController::class, 'handleCallback'])->name('payment.callback');
Route::get('/sales-data', [SalesController::class, 'getSalesData']);
