<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolManagersContrller;
Route::prefix('manager')->middleware('school_manager')->group(function() {
    Route::get('/dashboard',[SchoolManagersContrller::class,'index'])->name('manager.dashboard');
    Route::get('/users',[SchoolManagersContrller::class,'getUserData'])->name('manager.users');
    Route::get('/teachers',[SchoolManagersContrller::class,'getActiveTeachers'])->name('manager.teachers');
    Route::get('/newteachers',[SchoolManagersContrller::class,'getNewTeachers'])->name('manager.teachers.new');
    Route::get('/activestudents',[SchoolManagersContrller::class,'getActiveStudents'])->name('manager.students');
    Route::get('/newstudents',[SchoolManagersContrller::class,'getNewStudents'])->name('manager.students.new');
    Route::get('/activateTeacher/{id}',[SchoolManagersContrller::class,'activateTeacher'])->name('manager.activateTeacher');
    Route::get('/activateStudent/{id}',[SchoolManagersContrller::class,'activateStudent'])->name('manager.activateStudent');
    Route::get('/teacehr/{id}',[SchoolManagersContrller::class,'teacherDetail'])->name('manager.teachers.detail');
    Route::get('user-detail/{id}',[SchoolManagersContrller::class,'userDetail'])->name('manager.user.detail');
    Route::get('/exams',[SchoolManagersContrller::class,'examslist'])->name('manager.exams');
    Route::get('/questions',[SchoolManagersContrller::class,'getExamQuestions'])->name('manager.questions');
    Route::get('/question-detail/{id}',[SchoolManagersContrller::class,'questionDetail'])->name('manager.questions.detail');
    Route::get('/question/{id}/approve',[SchoolManagersContrller::class,'approveQuestion'])->name('manager.questions.approve');
    Route::get('/question/{id}/reject',[SchoolManagersContrller::class,'rejectQuestion'])->name('manager.questions.reject');
    Route::get('/assignSubject/{id}/{teacherId}',[SchoolManagersContrller::class,'assignSubject'])->name('manager.teachers.assign');
    Route::get('/unassignSubject/{id}/{teacherId}',[SchoolManagersContrller::class,'unassignSubject'])->name('manager.teachers.unassign');
    Route::get('/getTeacherSubjects/{id}',[SchoolManagersContrller::class,'getTeacherSubjects'])->name('manager.teachers.subjects');

});
