<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Models\School;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TinyMCEController;
require base_path('routes/staffroutes.php');
require base_path('routes/teacherroutes.php');
require base_path('routes/managersRoute.php');
require base_path('routes/studentRoutes.php');
Route::get('/', action: function () {
    $schools = School::all();
    return view('layouts.index', ['schools' => $schools]);
});


Route::get('/mezgeba', action: function () {
    return view('layouts.staff.register');
});

Route::post('/', [UserController::class, 'register']);
Route::post("/newstud", [StudentController::class, 'store']);
Route::post("/newteacher", [TeacherController::class, 'store']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

//WARNING: this are for the staff chars and graphs so pls dont touch them
Route::get('/users',[StaffController::class, 'getUserData'])->middleware('staff')->name('users');
Route::get('/schoolsCount',[StaffController::class, 'getSchoolData'])->middleware('staff')->name('schoolsCount');
Route::get('/getUserByRole',[StaffController::class, 'getUserByRole'])->middleware('staff')->name('getUserByRole');

Route::get('/timezone-test', function () {
    return [
        'timezone' => config('app.timezone'),
        'current_time' => now()->format('Y-m-d H:i:s'),
        'php_timezone' => date_default_timezone_get(),
    ];
});

Route::get('/student/exam/{id}/start', [ExamController::class, 'start'])->name('student.exam.start');
Route::post('/student/exam/{id}/submit', [ExamController::class, 'submit'])->name('student.exam.submit');
Route::get('/student/exam/{id}/result', [ExamController::class, 'result'])->name('student.exam.result');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Chat Routes
Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{group}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{group}/send', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/chat/{group}/messages', [ChatController::class, 'getMessages'])->name('chat.messages');
});
