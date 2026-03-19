<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller 
{
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $students = Student::paginate($perPage);
        
        return response()->json([
            'success' => true,
            'message' => 'Students retrieved',
            'data' => $students
        ], 200);
    }

    public function show($id)
    {
        $student = Student::with('courses')->findOrFail($id);
        
        return response()->json([
            'success' => true,
            'message' => 'Student retrieved',
            'data' => $student
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_number' => 'required|unique:students,student_number',
            'first_name'     => 'required',
            'last_name'      => 'required',
            'email'          => 'required|email|unique:students,email'
        ]);

        $student = Student::create($request->all());
        
        return response()->json([
            'success' => true,
            'message' => 'Student created successfully',
            'data' => $student
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        
        $request->validate([
            'student_number' => 'required|unique:students,student_number,' . $student->id,
            'first_name'     => 'required',
            'last_name'      => 'required',
            'email'          => 'required|email|unique:students,email,' . $student->id
        ]);

        $student->update($request->all());
        
        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully',
            'data' => $student
        ], 200);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Student deleted successfully',
            'data' => null
        ], 200);
    }

    /**
     * Get all courses for a student
     */
    public function courses($id)
    {
        $student = Student::findOrFail($id);
        $courses = $student->courses()->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Student courses retrieved',
            'data' => $courses
        ], 200);
    }

    /**
     * Get enrollments for a student
     */
    public function enrollments($id)
    {
        $student = Student::findOrFail($id);
        $enrollments = $student->courses()->with('enrollments')->get();
        
        return response()->json([
            'success' => true,
            'message' => 'Student enrollments retrieved',
            'data' => $enrollments
        ], 200);
    }
}





