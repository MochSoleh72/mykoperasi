<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth', 'member'])->group(function() {
    Route::resource('loan-requests', 'LoanRequestController');
});

Route::middleware(['auth', 'member'])->group(function() {
    Route::resource('loan-requests', 'LoanRequestController');
});

Route::middleware(['auth', 'admin'])->group(function() {
    Route::get('review', 'ReviewController@index')->name('reviews');
    Route::patch('review/{loan_request}/approve', 'ReviewController@approve')->name('reviews.approve');
    Route::patch('review/{loan_request}/reject', 'ReviewController@reject')->name('reviews.reject');
    Route::get('reports', 'ReportController@index')->name('reports.index');
    Route::resource('loans', 'LoanController', ['only' => [
        'index', 'show'
    ]]);
    Route::resource('loans.payments', 'PaymentController', ['only' => [
        'create', 'store', 'destroy'
    ]]);
});
