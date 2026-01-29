<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin User
        User::firstOrCreate(['email' => 'superadmin@pln.co.id'], [
            'name' => 'Super Admin',
            'role' => 'super admin',
            'password' => Hash::make('password123'),
        ]);

        // Create Admin Logistik User
        User::firstOrCreate(['email' => 'adminlogistik@pln.co.id'], [
            'name' => 'Admin Logistik',
            'role' => 'admin logistik',
            'phone' => null, // Admin harus mengisi nomor telepon sendiri
            'password' => Hash::make('password123'),
        ]);

        // Create User Logistik Users
        User::firstOrCreate(['email' => 'userlogistik@pln.co.id'], [
            'name' => 'User Logistik',
            'role' => 'user logistik',
            'password' => Hash::make('password123'),
        ]);
        User::firstOrCreate(['email' => 'userlogistik2@pln.co.id'], [
            'name' => 'User Logistik 2',
            'role' => 'user logistik',
            'password' => Hash::make('password123'),
        ]);

        // Create Admin HSE User
        User::firstOrCreate(['email' => 'adminhse@pln.co.id'], [
            'name' => 'Admin HSE',
            'role' => 'admin hse',
            'password' => Hash::make('password123'),
        ]);

        // Create User HSE User
        User::firstOrCreate(['email' => 'userhse@pln.co.id'], [
            'name' => 'User HSE',
            'role' => 'user hse',
            'password' => Hash::make('password123'),
        ]);
    }
}