<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $this->call([
            StudentsSeeder::class, // Menjalankan StudentsSeeder
            CourseSeeder::class,   // Menjalankan CourseSeeder
            SessionSeeder::class,  // Menjalankan SessionSeeder
        ]);
    }
}
