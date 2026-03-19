<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\SchoolDayController;

// Public routes (no authentication required)
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Protected routes (authentication required)
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/profile', [AuthController::class, 'profile']);
    Route::post('/auth/refresh', [AuthController::class, 'refresh']);

    // StudentController API routes
    Route::apiResource('students', StudentController::class);
    Route::get('/students/{id}/courses', [StudentController::class, 'courses']);
    Route::get('/students/{id}/enrollments', [StudentController::class, 'enrollments']);

    // CourseController API routes
    Route::apiResource('courses', CourseController::class);
    Route::get('/courses/{id}/students', [CourseController::class, 'students']);

    // EnrollmentController API routes
    Route::apiResource('enrollments', EnrollmentController::class);
    Route::post('/enrollments', [EnrollmentController::class, 'enroll'])->name('enroll');

    // SchoolDayController API routes
    Route::apiResource('school-days', SchoolDayController::class);
    Route::get('/school-days/by-range', [SchoolDayController::class, 'getByDateRange']);
    Route::get('/school-days/active/days', [SchoolDayController::class, 'getActiveDays']);
});

// Legacy route for compatibility
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
