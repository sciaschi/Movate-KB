<?php

namespace App\Http\Controllers\Admin\AccuracyScores;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use Inertia\Inertia;

class AdminAccuracyScoresController extends Controller
{
    public function index() {
        return Inertia::render('Admin/AccuracyScores/Index');
    }

    public function grade() {
        return Inertia::render('Admin/AccuracyScores/Grade');
    }

    public function getAllUsers() {
        return response()->json([
            'status' => true,
            'data' => User::get(['id', 'name', 'email'])
        ]);
    }
}
