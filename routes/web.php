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
    'prefix' => 'students',
    'namespace' => 'App\Http\Controllers',
], function () {
    Route::group([
        'middleware' => 'auth.students',
    ], function () {
        Route::get('/', [\App\Http\Controllers\StudentController::class, 'calendar'])->name('students.index');
        Route::get('tuition', [\App\Http\Controllers\StudentController::class, 'tuition'])->name('students.tuition');
        Route::get('grades', [\App\Http\Controllers\StudentController::class, 'grades'])->name('students.grades');

        Route::post('get-calendar-events', [\App\Http\Controllers\StudentController::class, 'getCalendarEvents']);
        Route::post('logout', [\App\Http\Controllers\StudentController::class, 'logout'])->name('students.logout');

        Route::post('set-attendance/{lesson_id}', [\App\Http\Controllers\StudentController::class, 'setAttendance']);
    });

    Route::get('login', [\App\Http\Controllers\StudentController::class, 'login'])->name('students.login');
    Route::post('login', [\App\Http\Controllers\StudentController::class, 'handleLogin']);
});
