<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoursesStudentRequest;
use App\Models\Course;
use App\Models\CoursesStudentReference;
use App\Models\User;

class CoursesStudentController extends Controller
{
    public function index()
    {
        $student_id = auth()->id();
        $courses_student_ref = CoursesStudentReference::where([
            'student_id' => $student_id
        ])->with('course')->get();

        return response()->json($courses_student_ref, 200);
    }

    public function show(Course $course)
    {
        return response()->json($course, 200);
    }

    public function updateStatus(CoursesStudentRequest $request, string $course_id)
    {
        $student_id = auth()->id();
        $courses_student_ref = CoursesStudentReference::where([
            'course_id' => $course_id,
            'student_id' => $student_id
        ])->firstOrFail();

        $courses_student_ref->update($request->validated());
        return response()->json(['success' => true], 204);
    }
}
