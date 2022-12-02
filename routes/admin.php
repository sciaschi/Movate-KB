<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'role:Admin'])->group(function() {
    Route::get('/dashboard'               , 'App\Http\Controllers\Admin\Dashboard\AdminDashboardController@index')->name('dashboard');

    Route::get('/users'                   , 'App\Http\Controllers\Admin\Users\AdminUsersController@index')->name('users');
    Route::get('/get-users'               , 'App\Http\Controllers\Admin\Users\AdminUsersController@getAllUsers')->name('get-users');

    Route::get('/accuracy-scores'         , 'App\Http\Controllers\Admin\AccuracyScores\AdminAccuracyScoresController@index')->name('accuracy-scores');
    Route::get('/accuracy-scores/grade'   , 'App\Http\Controllers\Admin\AccuracyScores\AdminAccuracyScoresController@grade')->name('grade-accuracy');
    Route::get('/accuracy-scores/history' , 'App\Http\Controllers\Admin\AccuracyScores\AdminAccuracyScoresController@grade')->name('accuracy-history');
});
