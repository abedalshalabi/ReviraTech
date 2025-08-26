<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Delete existing admin user if exists
        User::where('email', 'admin@admin.com')->delete();
        
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'), // Default password: password
            'email_verified_at' => now(),
        ]);
    }
}