<?php

use App\Enums\UserRoleEnum;
use App\Http\Controllers\CourseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//admin routes
Route::middleware(['auth:sanctum', 'role:' . UserRoleEnum::Admin->value])->group(function () {
    Route::resource('course', CourseController::class);
});

//student routes
Route::middleware(['auth:sanctum', 'role:' . UserRoleEnum::Student->value])->group(function () {
});