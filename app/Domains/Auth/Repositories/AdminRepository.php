<?php

namespace App\Domains\Auth\Repositories;

use App\Models\Admin;

class AdminRepository
{
    public $model;

    public function __construct(Admin $admin) 
    {
        $this->model = $admin;
    }

    public function create($request) : object 
    {
        return $this->model->create([
            'name'     => $request['name'],
            'email'    => $request['email'],
            'password' => bcrypt($request['password'])
        ]);  
    }

    public function findByEmail($email) : object 
    {
        return $this->model->where('email', $email)->first();
    }
    
}
