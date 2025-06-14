<?php

namespace App\Domains\Auth\Repositories;

use App\Models\User;

class UserRepository
{
    public $model;

    public function __construct(User $user) 
    {
        $this->model = $user;
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
