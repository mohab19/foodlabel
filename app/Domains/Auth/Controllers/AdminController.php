<?php

namespace App\Domains\Auth\Controllers;

use App\Http\Controllers\Controller;

// Requests
use App\Domains\Auth\Requests\LoginRequest;
use App\Domains\Auth\Requests\RegisterRequest;

// Services
use App\Domains\Auth\Services\AdminService;

class AdminController extends Controller
{
    public $admin_service;
    
    public function __construct(AdminService $admin_service) 
    {
        $this->admin_service = $admin_service;
    }

    public function save(RegisterRequest $request) 
    {
        $response = $this->admin_service->register($request->validated());

        return response()->json($response, $response['response_code']);
    }

    public function login(LoginRequest $request)
    {
        $response = $this->admin_service->login($request->validated());

        return response()->json($response, $response['response_code']);
    }
    
}
