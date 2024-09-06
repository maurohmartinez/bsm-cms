<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group([
    'prefix' => 'i-am-student',
    'namespace' => 'App\Http\Controllers',
], function () {
    Route::group([
        'middleware' => 'auth.students',
    ], function () {
        Route::get('/', [\App\Http\Controllers\StudentController::class, 'calendar'])->name('i-am-student.index');
        Route::get('tuition', [\App\Http\Controllers\StudentController::class, 'tuition'])->name('i-am-student.tuition');
        Route::get('grades', [\App\Http\Controllers\StudentController::class, 'grades'])->name('i-am-student.grades');

        Route::post('get-calendar-events', [\App\Http\Controllers\StudentController::class, 'getCalendarEvents']);
        Route::post('logout', [\App\Http\Controllers\StudentController::class, 'logout'])->name('i-am-student.logout');
    });

    Route::get('login', [\App\Http\Controllers\StudentController::class, 'login'])->name('i-am-student.login');
    Route::post('login', [\App\Http\Controllers\StudentController::class, 'handleLogin']);
});
