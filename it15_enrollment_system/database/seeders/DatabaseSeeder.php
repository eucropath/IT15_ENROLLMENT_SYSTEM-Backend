<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed courses first
        $this->call(CourseSeeder::class);

        // Seed students
        $this->call(StudentSeeder::class);

        // Seed school days (academic calendar)
        $this->call(SchoolDaySeeder::class);

        // Seed enrollments (assign students to courses)
        $this->call(EnrollmentSeeder::class);
    }
}

