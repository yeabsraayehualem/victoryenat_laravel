<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::prefix('student')->middleware('student')->group(function () {
    Route::get('/dashboard',[StudentController::class,'dashboard'])->name('student.dashboard');
    Route::get('/exam-schedules',[StudentController::class,'examSchedules'])->name('student.exam.schedule');
    Route::get('/exam-detail/{id}',[StudentController::class,'examDetail'])->name('exams.show');
    Route::get('/subjects',[StudentController::class,'subjects'])->name('student.subjects');
    Route::get('subject/{id}/lessons',[StudentController::class,'lessons'])->name('student.subject.lessons');
    Route::get('subject/{id}/lesson/{subId}', [StudentController::class, 'lessonDetail'])->name('lessons.show');

});
