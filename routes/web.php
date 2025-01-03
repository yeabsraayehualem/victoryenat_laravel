<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TeacherController;
use App\Models\School;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TinyMCEController;

Route::get('/', action: function () {
$schools= School::all();
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



Route::get('/staff/dashboard', function () {
    return view('staff.index');
})->middleware('staff')->name('staff.dashboard');
Route::get('/staff/schools', [StaffController::class, 'schools'])->middleware('staff')->name('staff.schools');
Route::get('/staff/schools/active', [StaffController::class, 'activeSchools'])->middleware('staff')->name('staff.schools.active');
Route::post('/staff/schools', [StaffController::class, 'addSchool'])->middleware('staff')->name('staff.addSchool');
Route::get('/staff/schools/delete/{id}', [StaffController::class, 'deleteSchool'])->middleware('staff')->name('staff.deleteSchool');
Route::get('/staff/schools/edit/{id}', [StaffController::class, 'editSchool'])->middleware('staff')->name('staff.schooldetail');
Route::post('/staff/schools/update/{id}', [StaffController::class, 'updateSchool'])->middleware('staff')->name('staff.updateSchool');
Route::get('staff/school-managers', [StaffController::class, 'schoolManagers'])->middleware('staff')->name('staff.schoolManagers');
Route::post('staff/school-managers', [StaffController::class, 'addSchoolManager'])->middleware('staff')->name('staff.addManager');
Route::get('/staff/teachers', [StaffController::class, 'teachers'])->middleware('staff')->name('staff.teachers');
Route::get("/staff/students", [StaffController::class, 'students'])->middleware('staff')->name('staff.students');
Route::get("/staff/managers", [StaffController::class, 'schoolManagers'])->middleware('staff')->name('staff.managers');
Route::get("/staff/staffs", [StaffController::class, 'staffs'])->middleware('staff')->name('staff.staffs');
Route::get("/staff/all", [StaffController::class, 'allusers'])->middleware('staff')->name('staff.allusers');
Route::get("/staff/edit-user/{id}", action: [StaffController::class, 'editUser'])->middleware('staff')->name('staff.editUser');
Route::post("/staff/edit-user/{id}", action: [StaffController::class, 'updateUserdata'])->middleware('staff')->name('staff.editUser');
Route::get("/staff/subjects",[StaffController::class,'allSubjects'])->middleware('staff')->name('staff.subjects.all');
Route::post("/staff/subjects",[StaffController::class,'addSubject'])->middleware('staff')->name('staff.subjects.add');
Route::get("/staff/subject/{id}",[StaffController::class,'subjectDetail'])->middleware('staff')->name('staff.subjectdetail');
Route::post("/staff/subject/{id}",[StaffController::class,'editSubject'])->middleware('staff')->name('staff.subject.edit');
Route::get("/staff/lessons",[StaffController::class,'allLessons'])->middleware('staff')->name('staff.lessons.all');
Route::get("/staff/lessons/new",[StaffController::class,'newLesson'])->middleware('staff')->name('staff.lessons.add');
Route::post("/staff/lessons/add",[StaffController::class,'addLesson'])->middleware('staff')->name('staff.lessons.addLesson');
Route::post('/lessonImage', [TinyMCEController::class, 'uploadImage'])->name('tinymce.upload');
Route::get("/staff/lessons/edit/{id}",[StaffController::class,'lessonDetail'])->middleware('staff')->name('staff.lessons.detail');
Route::post("/staff/lessons/edit/{id}",[StaffController::class,'editLesson'])->middleware('staff')->name('staff.lessons.editLesson');
