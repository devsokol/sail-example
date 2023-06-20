<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! User::exists()) {
            $role = Role::firstWhere('name', 'administrator');

            User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => Hash::make('12345'),
                'role_id' => $role->id
            ]);
        }
    }
}
