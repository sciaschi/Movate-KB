<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserAccuracyScore\UserAccuracyScore;
use Illuminate\Http\Request;
use App\Models\User\User;
use Inertia\Inertia;

class UserController extends Controller
{

    public function audits() {
        return Inertia::render('UserAudits/Index');
    }

    public function getAccuracy($id) {
        $accuracy = UserAccuracyScore::where('user_id', '=', $id)->pluck('accuracy_grade')->first();
        return response()->json([
            'status' => true,
            'accuracy' => $accuracy ? $accuracy . '%' : 'N/A'
        ]);
    }
}
