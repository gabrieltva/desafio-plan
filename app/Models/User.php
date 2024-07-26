<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'role' => UserRoleEnum::class,
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRoleEnum::Admin;
    }

    public function isStudent(): bool
    {
        return $this->role === UserRoleEnum::Student;
    }

    public function courses()
    {
        return $this->isAdmin() ? 
            $this->hasMany(Course::class, 'admin_id') : 
            $this->belongsToMany(User::class, 'courses_student_reference', 'student_id', 'course_id');
    }
    
    public function students()
    {
        return $this->isAdmin() ? $this->hasMany(User::class, 'admin_id') : null;
    }
}
