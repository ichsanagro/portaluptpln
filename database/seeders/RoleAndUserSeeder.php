<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create roles
        $superAdminRole = Role::firstOrCreate(['name' => 'super admin']);
        $adminLogistikRole = Role::firstOrCreate(['name' => 'admin logistik']);
        $userLogistikRole = Role::firstOrCreate(['name' => 'user logistik']);

        // Create Super Admin User
        $superAdmin = User::firstOrCreate(['email' => 'superadmin@pln.co.id'], [
            'name' => 'Super Admin',
            'password' => Hash::make('password123'),
        ]);
        $superAdmin->assignRole($superAdminRole);

        // Create Admin Logistik User
        $adminLogistik = User::firstOrCreate(['email' => 'adminlogistik@pln.co.id'], [
            'name' => 'Admin Logistik',
            'phone' => null, // Admin harus mengisi nomor telepon sendiri
            'password' => Hash::make('password123'),
        ]);
        $adminLogistik->assignRole($adminLogistikRole);

        // Create User Logistik User
        $userLogistik = User::firstOrCreate(['email' => 'userlogistik@pln.co.id'], [
            'name' => 'User Logistik',
            'password' => Hash::make('password123'),
        ]);
        $userLogistik->assignRole($userLogistikRole);
        // Create User Logistik User
        $userLogistik = User::firstOrCreate(['email' => 'userlogistik2@pln.co.id'], [
            'name' => 'User Logistik',
            'password' => Hash::make('password123'),
        ]);
        $userLogistik->assignRole($userLogistikRole);

        // Create HSE roles
        $adminHseRole = Role::firstOrCreate(['name' => 'admin hse']);
        $userHseRole = Role::firstOrCreate(['name' => 'user hse']);

        // Create Admin HSE User
        $adminHse = User::firstOrCreate(['email' => 'adminhse@pln.co.id'], [
            'name' => 'Admin HSE',
            'password' => Hash::make('password123'),
        ]);
        $adminHse->assignRole($adminHseRole);

        // Create User HSE User
        $userHse = User::firstOrCreate(['email' => 'userhse@pln.co.id'], [
            'name' => 'User HSE',
            'password' => Hash::make('password123'),
        ]);
        $userHse->assignRole($userHseRole);
    }
}