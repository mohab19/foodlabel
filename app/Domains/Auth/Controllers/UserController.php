<?php

namespace App\Domains\Auth\Controllers;

use App\Http\Controllers\Controller;

// Requests
use App\Domains\Auth\Requests\LoginRequest;
use App\Domains\Auth\Requests\RegisterRequest;

// Services
use App\Domains\Auth\Services\UserService;

class UserController extends Controller
{
    public $user_service;
    
    public function __construct(UserService $user_service) 
    {
        $this->user_service = $user_service;
    }

    public function save(RegisterRequest $request) 
    {
        $response = $this->user_service->register($request->validated());

        return response()->json($response, $response['response_code']);
    }

    public function login(LoginRequest $request)
    {
        $response = $this->user_service->login($request->validated());

        return response()->json($response, $response['response_code']);
    }

}
