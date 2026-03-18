<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;

Route::get('/', function () {
    return view('welcome');

});
Route::resource('students', StudentController::class);
Route::resource('courses', CourseController::class);

Route::post('/enroll', [EnrollmentController::class, 'enroll'])->name('enroll');
