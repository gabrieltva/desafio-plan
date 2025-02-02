<?php

use App\Enums\UserRoleEnum;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CoursesStudentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('json')->group(function() {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('admins', [UserController::class, 'listAdmins']);
    
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
    
    //admin routes
    Route::middleware(['auth:sanctum', 'role:' . UserRoleEnum::Admin->value])->group(function () {
        Route::resource('course', CourseController::class);
        Route::get('admin/students', [UserController::class, 'listStudentsByAdmin']);
        Route::get('admin/students/{id}', [UserController::class, 'listStudentAndCourses']);
    });
    
    //student routes
    Route::middleware(['auth:sanctum', 'role:' . UserRoleEnum::Student->value])->group(function () {
        Route::get('student/course', [CoursesStudentController::class, 'index']);
        Route::get('student/course/{course:id}', [CoursesStudentController::class, 'show']);
        Route::put('student/course/{course_id}', [CoursesStudentController::class, 'updateStatus']);
        Route::get('admin/list', [UserController::class, 'listAdmin']);
    });
});