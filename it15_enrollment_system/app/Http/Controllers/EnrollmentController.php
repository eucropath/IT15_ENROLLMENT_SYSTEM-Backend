<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with('student', 'course')->get();
        return response()->json($enrollments, 200);
    }

    public function enroll(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_id'  => 'required|exists:courses,id',
        ]);

        $student = Student::findOrFail($request->student_id);
        $course = Course::findOrFail($request->course_id);

        // Check capacity
        if ($course->students()->count() >= $course->capacity) {
            return response()->json(['error' => 'Course is already full.'], 409);
        }

        // Check duplicate enrollment
        if ($student->courses()->where('course_id', $course->id)->exists()) {
            return response()->json(['error' => 'Student already enrolled.'], 409);
        }

        $enrollment = $student->courses()->attach($course->id);

        return response()->json(['message' => 'Enrollment successful.'], 201);
    }

    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();
        return response()->json(['message' => 'Enrollment deleted successfully'], 200);
    }
}

