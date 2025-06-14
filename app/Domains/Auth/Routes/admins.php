<?php

use App\Domains\Auth\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::post('register', [AdminController::class, 'save']);
Route::post('login', [AdminController::class, 'login']);