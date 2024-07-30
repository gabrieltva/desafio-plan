<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::where('admin_id', auth()->id())->with('students')->get();
        return response()->json($courses, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        $course = Course::create(['admin_id' => auth()->id(), ...$request->validated()]);
        
        if ($request->has('students')) {
            $course->students()->attach($request->input('students'));
        }

        return response()->json($course->with('students'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        if ($course->admin_id != auth()->id()) {
            return response()->json(['message' => 'Course not found.'], 404);
        }

        return response()->json($course->with('students')->get(), 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, Course $course)
    {
        if ($course->admin_id != auth()->id()) {
            return response()->json(['message' => 'Course not found.'], 404);
        }

        $course->update($request->validated());

        if ($request->has('students')) {
            $course->students()->sync($request->input('students'));
        }

        return response()->json($course->with('students'), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        if ($course->admin_id != auth()->id()) {
            return response()->json(['message' => 'Course not found.'], 404);
        }

        if ($course->delete()) {
            return response()->json(['success' => true], 204);
        }
        
        return response()->json(['success' => false], 500);
    }
}
