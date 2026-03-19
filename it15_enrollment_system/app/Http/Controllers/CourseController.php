<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $courses = Course::paginate($perPage);
        
        return response()->json([
            'success' => true,
            'message' => 'Courses retrieved',
            'data' => $courses
        ], 200);
    }

    public function show($id)
    {
        $course = Course::with('students')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'message' => 'Course retrieved',
            'data' => $course
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_code' => 'required|unique:courses,course_code',
            'course_name' => 'required',
            'capacity'    => 'required|integer|min:1'
        ]);

        $course = Course::create($request->all());
        
        return response()->json([
            'success' => true,
            'message' => 'Course created successfully',
            'data' => $course
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'course_code' => 'required|string|max:20|unique:courses,course_code,' . $course->id,
            'course_name' => 'required|string|max:255',
            'capacity'    => 'required|integer|min:1'
        ]);

        $course->update($request->all());
        
        return response()->json([
            'success' => true,
            'message' => 'Course updated successfully',
            'data' => $course
        ], 200);
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Course deleted successfully',
            'data' => null
        ], 200);
    }

    /**
     * Get all students in a course
     */
    public function students($id)
    {
        $course = Course::findOrFail($id);
        $students = $course->students()->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Course students retrieved',
            'data' => $students
        ], 200);
    }
}


