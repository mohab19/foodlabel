<?php

namespace App\Domains\Auth\Services;

use Illuminate\Support\Facades\Hash;
use App\Domains\Auth\Repositories\AdminRepository;

class AdminService
{
    public $admin_repository;

    public function __construct(AdminRepository $admin_repository) 
    {
        $this->admin_repository = $admin_repository;
    }

    public function register($request) : array 
    {
        $user = $this->admin_repository->create($request);
        
        if($user) {
            return [
                'response_code'    => 201,
                'response_message' => 'User registered successfully !',
                'response_data'    => $user->toArray()
            ];
        }

        return [
            'response_code'    => 400,
            'response_message' => 'User registeration Failed !',
            'response_data'    => []
        ];
    }

    public function login($request) : array 
    {
        $user = $this->admin_repository->findByEmail($request['email']);

        if (! $user || ! Hash::check($request['password'], $user->password)) {
            return [
                'response_code'    => 401,
                'response_message' => 'Invalid credentials !',
                'response_data'    => [],
            ];
        }
        // Delete all existing tokens
        $user->tokens()->delete();
        $user['token'] = $user->createToken('user_'.$user->id.'_token')->plainTextToken;

        return [
            'response_code'    => 200,
            'response_message' => 'Logged in Successfully',
            'response_data'    => $user->toArray(),
        ];
    }
    
}
