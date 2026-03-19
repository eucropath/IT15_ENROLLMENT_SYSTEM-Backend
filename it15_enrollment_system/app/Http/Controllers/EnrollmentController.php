<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $enrollments = Enrollment::with('student', 'course')->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'message' => 'Enrollments retrieved',
            'data' => $enrollments
        ], 200);
    }

    public function show($id)
    {
        $enrollment = Enrollment::with('student', 'course')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'message' => 'Enrollment retrieved',
            'data' => $enrollment
        ], 200);
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
            return response()->json([
                'success' => false,
                'message' => 'Course is already full.',
                'data' => null
            ], 409);
        }

        // Check duplicate enrollment
        if ($student->courses()->where('course_id', $course->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Student already enrolled in this course.',
                'data' => null
            ], 409);
        }

        $student->courses()->attach($course->id);
        
        // Get the created enrollment
        $enrollment = Enrollment::where('student_id', $student->id)
                                ->where('course_id', $course->id)
                                ->first();

        return response()->json([
            'success' => true,
            'message' => 'Enrollment successful.',
            'data' => $enrollment
        ], 201);
    }

    public function store(Request $request)
    {
        // Alias for enroll method
        return $this->enroll($request);
    }

    public function destroy($id)
    {
        $enrollment = Enrollment::findOrFail($id);
        $enrollment->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Enrollment deleted successfully',
            'data' => null
        ], 200);
    }
}

