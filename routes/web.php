<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TeacherController;
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
