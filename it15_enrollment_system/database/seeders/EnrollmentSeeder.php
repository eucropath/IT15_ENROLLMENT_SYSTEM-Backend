<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Course;

class EnrollmentSeeder extends Seeder
{
    /**
     * Create enrollments for students in courses
     * Each student is enrolled in 3-5 random courses
     */
    public function run()
    {
        $students = Student::all();
        $courses = Course::all();

        if ($students->isEmpty() || $courses->isEmpty()) {
            return;
        }

        foreach ($students as $student) {
            // Randomly select 3-5 courses for each student
            $numberOfCourses = rand(3, 5);
            $randomCourses = $courses->random(min($numberOfCourses, $courses->count()));

            // Attach courses to student (create enrollments)
            foreach ($randomCourses as $course) {
                $student->courses()->attach($course->id);
            }
        }
    }
}

