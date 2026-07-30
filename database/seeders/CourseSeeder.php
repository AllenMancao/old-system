<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            ['course_code' => 'BSCS', 'course_name' => 'BS Computer Science', 'required_hours' => 488],
            ['course_code' => 'BSIT-IS', 'course_name' => 'BSIT - Information Systems', 'required_hours' => 488],
            ['course_code' => 'BSIT-BTM', 'course_name' => 'BSIT - Business Technology Management', 'required_hours' => 488],
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate(['course_code' => $course['course_code']], $course);
        }
    }
}