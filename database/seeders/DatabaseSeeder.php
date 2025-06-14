<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create the first specific user
        User::factory()->create([
            'name'     => 'First User',
            'email'    => 'user@gmail.com',
            'password' => 'password',
        ]);

        // Create 9 additional random users
        User::factory(9)->create();

        // Create one admin
        Admin::factory()->create();
    }

}
