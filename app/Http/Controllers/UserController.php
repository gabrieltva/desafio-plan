<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function listStudentsByAdmin()
    {
        $admin_id = auth()->id();
        $students = User::where('admin_id', $admin_id)->get();

        return response()->json($students, 200);
    }

    public function listCoursesByStudents(User $user)
    {
        $admin_id = auth()->id();
        if ($user->admin_id != $admin_id) {
            return response()->json(['message' => 'You are not allowed to access this user\'s courses'], 403);
        }

        $user->with('courses');
        $courses = $user->courses()->get();
        return response()->json($courses, 200);
    }
}
