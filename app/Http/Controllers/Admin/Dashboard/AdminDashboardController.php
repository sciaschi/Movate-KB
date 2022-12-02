<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index() {
        return Inertia::render('Admin/Dashboard/Index');
    }
}
