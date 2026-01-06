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
        $superAdminRole = Role::create(['name' => 'super admin']);
        $adminLogistikRole = Role::create(['name' => 'admin logistik']);
        $userLogistikRole = Role::create(['name' => 'user logistik']);

        // Create Super Admin User
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@pln.co.id',
            'password' => Hash::make('password123'),
        ]);
        $superAdmin->assignRole($superAdminRole);

        // Create Admin Logistik User
        $adminLogistik = User::factory()->create([
            'name' => 'Admin Logistik',
            'email' => 'adminlogistik@pln.co.id',
            'password' => Hash::make('password123'),
        ]);
        $adminLogistik->assignRole($adminLogistikRole);

        // Create User Logistik User
        $userLogistik = User::factory()->create([
            'name' => 'User Logistik',
            'email' => 'userlogistik@pln.co.id',
            'password' => Hash::make('password123'),
        ]);
        $userLogistik->assignRole($userLogistikRole);
    }
}