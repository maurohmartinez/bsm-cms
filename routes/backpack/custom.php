<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers',
], function () { // custom admin routes

    Route::get('dashboard', function () {
        return \Illuminate\Support\Facades\Redirect::to(backpack_url('lesson/calendar'));
    })->name('backpack.dashboard');
    Route::get('/', function () {
        return \Illuminate\Support\Facades\Redirect::to(backpack_url('lesson/calendar'));
    })->name('backpack');

    Route::crud('lesson', 'LessonCrudController');
    Route::crud('user', 'UserCrudController');
    Route::crud('teacher', 'TeacherCrudController');
    Route::crud('subject-category', 'SubjectCategoryCrudController');
    Route::crud('subject', 'SubjectCrudController');
    Route::crud('year', 'YearCrudController');
    Route::crud('transaction-category', 'TransactionCategoryCrudController');
    Route::crud('vendor', 'VendorCrudController');
    Route::crud('customer', 'CustomerCrudController');
    Route::crud('transaction', 'TransactionCrudController');
    Route::get('charts/bookkeeping', 'Charts\BookkeepingChartController@response')->name('charts.bookkeeping.index');
}); // this should be the absolute last line of this file
