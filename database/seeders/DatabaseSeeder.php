<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles first
        $roles = ['admin', 'editor', 'reviewer', 'author'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Create super admin
        User::firstOrCreate(
            ['email' => 'admin@ajms.com'],
            [
                'name'              => 'Super Admin',
                'password'          => Hash::make('password'),
                'role_id'           => Role::where('name', 'admin')->value('id'),
                'email_verified_at' => now(),
                'status'            => 'active',
            ]
        );

        // Create a test editor
        User::firstOrCreate(
            ['email' => 'editor@ajms.com'],
            [
                'name'              => 'Chief Editor',
                'password'          => Hash::make('password'),
                'role_id'           => Role::where('name', 'editor')->value('id'),
                'email_verified_at' => now(),
                'status'            => 'active',
            ]
        );

        // Create a test reviewer
        User::firstOrCreate(
            ['email' => 'reviewer@ajms.com'],
            [
                'name'              => 'Test Reviewer',
                'password'          => Hash::make('password'),
                'role_id'           => Role::where('name', 'reviewer')->value('id'),
                'email_verified_at' => now(),
                'status'            => 'active',
            ]
        );

        // Create a test author
        User::firstOrCreate(
            ['email' => 'author@ajms.com'],
            [
                'name'              => 'Test Author',
                'password'          => Hash::make('password'),
                'role_id'           => Role::where('name', 'author')->value('id'),
                'email_verified_at' => now(),
                'status'            => 'active',
            ]
        );
    }
}
