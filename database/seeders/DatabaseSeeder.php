<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'role_name' => 'Admin',
            'access_level' => 1,
        ]);

        User::create([
            'role_id' => 1,
            'first_name' => 'Donald',
            'last_name' => 'Trump',
            'email' => 'example1@gmail.com',
            'password' => Hash::make('12345678'),
            'phone' => '111-111-1111',
            'date_of_birth' => '1946-06-14',
            'is_approved' => true,
        ]);

        Employee::create([
            'user_id' => 1,
            'role_id' => 1,
            'salary' => 1000000.00,
        ]);
    }
}
