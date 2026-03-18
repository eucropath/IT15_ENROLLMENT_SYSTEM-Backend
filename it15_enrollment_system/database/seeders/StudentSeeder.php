<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Seed 500 student records with demographic information
     */
    public function run()
    {
        $faker = Faker::create('en_PH'); // Philippine locale for realistic names

        // Create 500 students in bulk for better performance
        $students = [];
        for ($i = 1; $i <= 500; $i++) {
            $students[] = [
                'student_number' => sprintf('2026-%05d', $i),
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'email' => $faker->unique()->email(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert in batches of 100 for performance
            if ($i % 100 == 0) {
                Student::insert($students);
                $students = [];
            }
        }

        // Insert any remaining records
        if (!empty($students)) {
            Student::insert($students);
        }
    }
}
