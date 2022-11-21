<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'role:Admin'])->group(function() {
        Route::get('/dashboard', 'App\Http\Controllers\Admin\Dashboard\AdminDashboardController@index')->name('dashboard');
});
