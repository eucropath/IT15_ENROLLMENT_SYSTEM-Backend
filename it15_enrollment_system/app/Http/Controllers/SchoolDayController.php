<?php

namespace App\Http\Controllers;

use App\Models\SchoolDay;
use Illuminate\Http\Request;

class SchoolDayController extends Controller
{
    /**
     * Display a listing of school days
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $schoolDays = SchoolDay::paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'School days retrieved',
            'data' => $schoolDays
        ]);
    }

    /**
     * Store a newly created school day
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date|unique:school_days,date',
            'day_type' => 'required|string|in:regular,holiday,exam,special',
            'description' => 'nullable|string',
            'is_school_day' => 'required|boolean',
            'academic_year' => 'nullable|string',
        ]);

        $schoolDay = SchoolDay::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'School day created successfully',
            'data' => $schoolDay
        ], 201);
    }

    /**
     * Display the specified school day
     */
    public function show($id)
    {
        $schoolDay = SchoolDay::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'School day retrieved',
            'data' => $schoolDay
        ]);
    }

    /**
     * Update the specified school day
     */
    public function update(Request $request, $id)
    {
        $schoolDay = SchoolDay::findOrFail($id);

        $validated = $request->validate([
            'date' => 'sometimes|date|unique:school_days,date,' . $schoolDay->id,
            'day_type' => 'sometimes|string|in:regular,holiday,exam,special',
            'description' => 'nullable|string',
            'is_school_day' => 'sometimes|boolean',
            'academic_year' => 'nullable|string',
        ]);

        $schoolDay->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'School day updated successfully',
            'data' => $schoolDay
        ]);
    }

    /**
     * Remove the specified school day
     */
    public function destroy($id)
    {
        $schoolDay = SchoolDay::findOrFail($id);
        $schoolDay->delete();

        return response()->json([
            'success' => true,
            'message' => 'School day deleted successfully',
            'data' => null
        ]);
    }

    /**
     * Get school days in a date range
     */
    public function getByDateRange(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $schoolDays = SchoolDay::whereBetween('date', [
            $validated['start_date'],
            $validated['end_date']
        ])->get();

        return response()->json([
            'success' => true,
            'message' => 'School days in range retrieved',
            'data' => $schoolDays
        ]);
    }

    /**
     * Get only active school days
     */
    public function getActiveDays()
    {
        $schoolDays = SchoolDay::where('is_school_day', true)->get();

        return response()->json([
            'success' => true,
            'message' => 'Active school days retrieved',
            'data' => $schoolDays
        ]);
    }
}
