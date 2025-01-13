<?php

use App\Http\Controllers\BalanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/deposit', [BalanceController::class, 'deposit']);
Route::post('/withdraw', [BalanceController::class, 'withdraw']);
Route::post('/transfer', [BalanceController::class, 'transfer']);
Route::get('/balance', [BalanceController::class, 'balance']);
Route::get('/transactions', [BalanceController::class, 'transactions']);
