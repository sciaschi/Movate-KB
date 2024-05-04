<?php

namespace App\Http\Controllers\User\Dashboard;

use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Models\Trend\Trend;
use App\Models\Term\Term;
use Embed\Embed;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index() {
        return Inertia::render('Dashboard/Index', [
            'can-add-trend' => Auth::user()->can('add-trend')
        ]);
    }
}
