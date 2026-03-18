<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// StudentController API routes
Route::apiResource('students', StudentController::class);

// CourseController API routes
Route::apiResource('courses', CourseController::class);

// EnrollmentController API routes
Route::post('/enrollments', [EnrollmentController::class, 'enroll'])->name('enroll');
Route::get('/enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
Route::delete('/enrollments/{id}', [EnrollmentController::class, 'destroy'])->name('enrollments.destroy');
