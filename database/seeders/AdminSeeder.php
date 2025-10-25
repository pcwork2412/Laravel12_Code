<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      // Check if admin already exists
        if (!User::where('role', 'admin')->exists()) {
            User::create([
                'name'     => 'Super Admin',
                'email'    => 'admin@school.com', // Default email
                'password' => Hash::make('Admin@123'), // Default password
                'role'     => 'admin',
                'status'   => 'approved', // Admin is always approved
            ]);
        }
    }
}
