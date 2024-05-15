<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use Carbon\Carbon;
use Inertia\Inertia;

class AdminUsersController extends Controller
{
    public function index() {
        return Inertia::render('Admin/Users/Index');
    }

    public function create() {
        return Inertia::render('Admin/Users/Create');
    }

    public function edit() {
        return Inertia::render('Admin/Users/Edit');
    }

    public function delete() {
        return Inertia::render('Admin/Users/Edit');
    }

    public function getAllUsersWithAccuracies() {
        $data = User::with(['accuracy_scores' => function($q) {
            $q->latest();
        }])->paginate(15)->through(function ($val){
            $accuracyScores = $val->accuracy_scores()->first();
            return [
                'id'             => $val->id,
                'name'           => $val->name,
                'accuracy_score' => $accuracyScores ? $accuracyScores->accuracy_grade . '%' : 'N/A',
                'last_updated'   => $accuracyScores ? Carbon::parse($accuracyScores->updated_at)->format('m/d/Y') : 'No Audits Yet'
            ];
        });

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function getAllUsers() {
        $data = User::with('roles')->paginate(15)->through(function($e){
            return [
                'id'             => $e->id,
                'name'           => $e->name,
                'email'          => $e->email,
                'role'           => $e->roles->first()->name,
                'actions'        => $e->actions()
            ];
        });

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}
