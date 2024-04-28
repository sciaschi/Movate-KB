<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User\User;

class UserController extends Controller
{
    public function getModerationsPerHour(Request $request) {
        $data = $request->all();
        $user = Auth::user();

//        $count = $data['moderations'];

        return [
            'status' => true,
            'result' => $data
        ];

    }
}
