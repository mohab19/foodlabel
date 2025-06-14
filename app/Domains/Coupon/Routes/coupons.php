<?php

use Illuminate\Support\Facades\Route;
use App\Domains\Coupon\Controllers\CouponController;

Route::middleware(['auth:sanctum', 'admin'])->group(function() {
    Route::post('create', [CouponController::class, 'store']);
});

Route::post('validate', [CouponController::class, 'update']);