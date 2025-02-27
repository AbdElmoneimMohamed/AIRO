<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\QuotationController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')
    ->post('/quotation', [QuotationController::class, 'getQuotation']);

