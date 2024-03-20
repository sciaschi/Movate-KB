<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/dashboard'         , 'App\Http\Controllers\User\Dashboard\DashboardController@index')->name('dashboard');
    Route::post('/trend/store'      , 'App\Http\Controllers\User\Dashboard\DashboardController@storeTrendUrl')->name('add_trend');
    Route::get('/trend/get-trends'  , 'App\Http\Controllers\User\Dashboard\DashboardController@getTrends')->name('get_trends');

    Route::get('/term/get-recently-added-terms' , 'App\Http\Controllers\Term\TermController@getRecentlyAddedTerms')->name('get-recently-added-terms');
    Route::get('/term/get-all-terms'            , 'App\Http\Controllers\Term\TermController@getAllTerms')->name('get-all-terms');
    Route::get('/term/term-links-by-id/{id}'    , 'App\Http\Controllers\Term\TermController@getTermLinksById')->name('get-term-links-by-id');
    Route::put('/term/update-term'              , 'App\Http\Controllers\Term\TermController@updateTerm')->name('update-term');
    Route::post('/term/add-term'                , 'App\Http\Controllers\Term\TermController@addTerm')->name('add-term');
    Route::post('/term/delete-term-link'        , 'App\Http\Controllers\Term\TermController@deleteTermLink')->name('delete-term-link');

    Route::get('/search-terms'       , 'App\Http\Controllers\Term\TermController@index')->name('terms');
    Route::post('/search-term'       , 'App\Http\Controllers\Term\TermController@searchTerm')->name('search-term');
    Route::post('/search-term/store' , 'App\Http\Controllers\Term\TermController@store')->name('add_term');


    Route::get('/translate' , 'App\Http\Controllers\Translate\TranslateController@index')->name('translate');
    Route::get('/get-languages' , 'App\Http\Controllers\Translate\TranslateController@getLanguages')->name('get-languages');
    Route::post('/translate-text' , 'App\Http\Controllers\Translate\TranslateController@translate')->name('translate-text');
});


require __DIR__.'/auth.php';
require __DIR__.'/admin.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
