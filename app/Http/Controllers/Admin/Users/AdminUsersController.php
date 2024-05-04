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
        }])->get(['id', 'name', 'email']);

        $mappedData = $data->map(function($e){
            return [
                'id'             => $e->id,
                'name'           => $e->name,
                'email'          => $e->email,
                'accuracy_score' => $e->accuracy_scores ? (string)$e->accuracy_scores->first()->accuracy_grade : 'N/A',
                'last_updated'   => $e->accuracy_scores ? Carbon::parse($e->accuracy_scores->first()->updated_at)->format('m/d/Y') : ''
            ];
        });

        return response()->json([
            'status' => true,
            'data' => $mappedData
        ]);
    }

    public function getAllUsers() {
        $data = User::with('roles')->get()->map(function($e){
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
