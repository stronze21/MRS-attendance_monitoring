<?php

use App\Livewire\AttendanceInterface;
use App\Livewire\HolidayList;
use App\Livewire\LevelList;
use App\Livewire\Report\Dtr;
use App\Livewire\Report\Sf2;
use App\Livewire\StudentList;
use App\Livewire\SystemConfigurations\SmsGateway;
use App\Livewire\SystemConfigurations\SmsGatewayDetails;
use App\Livewire\TeacherList;
use App\Livewire\ViewClassSection;
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
    return redirect(route('login'));
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

    Route::prefix('/settings')->name('settings.')->group(function () {
        Route::get('/sms', SmsGatewayDetails::class)->name('sms');
        Route::get('/holidays', HolidayList::class)->name('holidays');
        Route::get('/levels', LevelList::class)->name('levels');
        Route::get('/levels/view/{level_id}', ViewClassSection::class)->name('levels.view');
    });

    Route::prefix('/report')->name('report.')->group(function () {
        Route::get('/Daily-Attendance-Report-for-Learners/{from}/{to}', Sf2::class)->name('sf2');
    });

    Route::get('/dtr/interface', AttendanceInterface::class)->name('dtr.interface');
    Route::get('/dtr/report/{teacher_id}', Dtr::class)->name('dtr.report');
});
