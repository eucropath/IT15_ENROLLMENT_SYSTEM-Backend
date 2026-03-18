<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller 
{
    public function index()
    {
        $students = Student::all();
        return response()->json($students, 200);
    }

    public function show($id)
    {
        $student = Student::with('courses')->findOrFail($id);
        return response()->json($student, 200);
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
        return response()->json($student, 201);
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
        return response()->json($student, 200);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return response()->json(['message' => 'Student deleted successfully'], 200);
    }
}





