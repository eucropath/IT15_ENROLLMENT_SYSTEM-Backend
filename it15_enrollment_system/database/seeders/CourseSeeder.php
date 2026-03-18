<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Seed 20+ courses across different departments
     */
    public function run()
    {
        $courses = [
            // Information Technology Department (6 courses)
            [
                'course_code' => 'IT101',
                'course_name' => 'Introduction to Programming',
                'capacity' => 40
            ],
            [
                'course_code' => 'IT102',
                'course_name' => 'Data Structures',
                'capacity' => 35
            ],
            [
                'course_code' => 'IT201',
                'course_name' => 'Database Systems',
                'capacity' => 30
            ],
            [
                'course_code' => 'IT202',
                'course_name' => 'Web Development',
                'capacity' => 40
            ],
            [
                'course_code' => 'IT301',
                'course_name' => 'Software Engineering',
                'capacity' => 35
            ],
            [
                'course_code' => 'IT302',
                'course_name' => 'Mobile App Development',
                'capacity' => 30
            ],

            // Computer Science Department (5 courses)
            [
                'course_code' => 'CS101',
                'course_name' => 'Algorithm Design',
                'capacity' => 35
            ],
            [
                'course_code' => 'CS102',
                'course_name' => 'Computer Networks',
                'capacity' => 32
            ],
            [
                'course_code' => 'CS201',
                'course_name' => 'Operating Systems',
                'capacity' => 30
            ],
            [
                'course_code' => 'CS301',
                'course_name' => 'Artificial Intelligence',
                'capacity' => 28
            ],
            [
                'course_code' => 'CS302',
                'course_name' => 'Machine Learning Fundamentals',
                'capacity' => 25
            ],

            // Information Systems Department (5 courses)
            [
                'course_code' => 'IS101',
                'course_name' => 'Business Information Systems',
                'capacity' => 40
            ],
            [
                'course_code' => 'IS102',
                'course_name' => 'Enterprise Resource Planning',
                'capacity' => 35
            ],
            [
                'course_code' => 'IS201',
                'course_name' => 'Systems Analysis & Design',
                'capacity' => 30
            ],
            [
                'course_code' => 'IS202',
                'course_name' => 'Network Security',
                'capacity' => 28
            ],
            [
                'course_code' => 'IS301',
                'course_name' => 'Cloud Computing',
                'capacity' => 32
            ],

            // General Education Department (4 courses)
            [
                'course_code' => 'GE101',
                'course_name' => 'English Communication',
                'capacity' => 50
            ],
            [
                'course_code' => 'GE102',
                'course_name' => 'Mathematics for Computing',
                'capacity' => 45
            ],
            [
                'course_code' => 'GE201',
                'course_name' => 'Professional Ethics',
                'capacity' => 40
            ],
            [
                'course_code' => 'GE202',
                'course_name' => 'Technical Writing',
                'capacity' => 38
            ]
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}

