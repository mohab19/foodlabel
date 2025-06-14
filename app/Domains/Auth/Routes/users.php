<?php

use App\Domains\Auth\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('register', [UserController::class, 'save']);
Route::post('login', [UserController::class, 'login']);