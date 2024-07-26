<?php

use App\Enums\UserRoleEnum;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
});

//admin routes
Route::middleware(['auth:sanctum', 'role:' . UserRoleEnum::Admin->value])->group(function () {
    Route::resource('course', CourseController::class);
});

//student routes
Route::middleware(['auth:sanctum', 'role:' . UserRoleEnum::Student->value])->group(function () {
});