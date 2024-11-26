<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
<<<<<<< HEAD
=======

>>>>>>> ad26fa54b6adb5a30f5dd1d6022296267f880ff2

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create([
            'role_name' => 'Admin',
<<<<<<< HEAD
            'access_level' => 1
        ]);
=======
            'access_level' => 1,
        ]);

        
>>>>>>> ad26fa54b6adb5a30f5dd1d6022296267f880ff2
    }
}
