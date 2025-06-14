<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'response_code'    => 200,
        'response_message' => 'API Route Welcome Message',
        'response_data'    => []
    ]);
});


