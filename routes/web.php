<?php

use App\Livewire\AttendanceInterface;
use App\Livewire\StudentList;
use App\Livewire\TeacherList;
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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('/students')->name('student.')->group(function () {
        Route::get('/list', StudentList::class)->name('list');
    });

    Route::prefix('/teachers')->name('teacher.')->group(function () {
        Route::get('/list', TeacherList::class)->name('list');
    });

    Route::get('/dtr/interface', AttendanceInterface::class)->name('dtr.interface');
});
