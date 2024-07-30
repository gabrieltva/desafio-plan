<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursesStudentReference extends Model
{
    use HasFactory;

    protected $table = 'courses_student_reference';

    protected $fillable = [ 
        'student_id',
        'course_id',
        'status'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}
