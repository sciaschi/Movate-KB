<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use Inertia\Inertia;

class AdminUsersController extends Controller
{
    public function index() {
        return Inertia::render('Admin/Users/Index');
    }

    public function getAllUsers() {
        return response()->json([
            'status' => true,
            'data' => User::get(['id', 'name', 'email'])
        ]);
    }
}
