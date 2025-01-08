<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
Route::prefix('teacher')->middleware('teacher')->group(function() {
    Route::get('/dashboard',[TeacherController::class,'dashboard'])->name('teacher.dashboard');
    Route::get('/questionsByMonth', [TeacherController::class, 'questionperMonth'])->name('teacher.questionperMonth');
    Route::get('/subjects', [TeacherController::class, 'teacherSubjects'])->name('teacher.subjects');
    Route::get('/subjectDetail/{subject}', [TeacherController::class, 'subjectDetail'])->name('teacher.subjectdetail');
    Route::get('/addQuestion', [TeacherController::class, 'newQuestion'])->name('teacher.newQuestion');
    Route::post('/addQuestion', [TeacherController::class, 'addQuestion'])->name('teacher.addQuestion');
    Route::get('/editQuestion/{id}', [TeacherController::class, 'editQuestion'])->name('teacher.editQuestion');
    Route::post('/editQuestion/{id}', [TeacherController::class, 'editQuestion'])->name('teacher.editQuestion');
    Route::get('/questions', [TeacherController::class, 'questions'])->name('teacher.questions');
    Route::get('/questionDetail/{question}', [TeacherController::class, 'questionDetail'])->name('teacher.questionDetail');
    Route::get('/exams', [TeacherController::class, 'upcomingExams'])->name('teacher.upcomingExams');
    Route::get('/pastExams', [TeacherController::class, 'pastExams'])->name('teacher.pastExams');
    Route::get('/examDetail/{exam}', [TeacherController::class, 'examDetail'])->name('teacher.examDetail');
});

