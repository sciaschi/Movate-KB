<?php

use App\Http\Controllers\Admin\Users\AdminUsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified', 'role:Admin'])->group(function() {
    Route::get('/dashboard'                     , 'App\Http\Controllers\Admin\Dashboard\AdminDashboardController@index')->name('dashboard');

    Route::controller(AdminUsersController::class)->prefix('users')->name('users.')->group(function() {
        Route::get('/index'                    , 'index')->name('index');
        Route::get('/create'                   , 'create')->name('create');
        Route::get('/edit/{id}'                , 'edit')->name('edit');
        Route::post('/delete/{id}'             , 'delete')->name('delete');
        Route::get('/get-users'                , 'getAllUsers')->name('get-users');
        Route::get('/get-users-with-accuracies', 'getAllUsersWithAccuracies')->name('get-users-with-accuracies');
    });


    Route::get('/accuracy-scores'               , 'App\Http\Controllers\Admin\AccuracyScores\AdminAccuracyScoresController@index')->name('accuracy-scores');
    Route::get('/accuracy-scores/grade/{id}'    , 'App\Http\Controllers\Admin\AccuracyScores\AdminAccuracyScoresController@grade')->name('grade-accuracy');
    Route::get('/accuracy-scores/history/{id}'  , 'App\Http\Controllers\Admin\AccuracyScores\AdminAccuracyScoresController@historical')->name('accuracy-history');
    Route::post('/accuracy-scores/get-history'  , 'App\Http\Controllers\Admin\AccuracyScores\AdminAccuracyScoresController@getHistoricalData')->name('get-accuracy-history');
    Route::post('/accuracy-scores/get-team-averages', 'App\Http\Controllers\Admin\AccuracyScores\AdminAccuracyScoresController@getAverageAccuracyByDates')->name('get-team-averages');
    Route::post('/accuracy-scores/create'       , 'App\Http\Controllers\Admin\AccuracyScores\AdminAccuracyScoresController@createAccuracyScore')->name('create-accuracy-score');
});
