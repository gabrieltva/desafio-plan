<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Models\User;

class UserController extends Controller
{
    public function listStudentsByAdmin()
    {
        $admin_id = auth()->id();
        $students = User::where('admin_id', $admin_id)->get();

        return response()->json($students, 200);
    }

    public function listAdmin()
    {
        $admins = User::where('role', UserRoleEnum::Admin)
                    ->select('id', 'name')
                    ->get();
        return response()->json($admins, 200);
    }
}
