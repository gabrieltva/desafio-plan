<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'title',
        'description',
    ];

    public function admin()
    {
        $this->belongsTo(User::class, 'admin_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'courses_student_reference', 'course_id', 'student_id');
    }
}
