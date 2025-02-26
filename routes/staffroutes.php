<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffExamController;
use App\Http\Controllers\TinyMCEController;

Route::prefix('/staff')->middleware(['staff'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard');
    
    // Schools Management
    Route::get('/schools', [StaffController::class, 'schools'])->name('staff.schools');
    Route::get('/schools/active', [StaffController::class, 'activeSchools'])->name('staff.schools.active');
    Route::get('/schools/inactive', [StaffController::class, 'inactiveSchools'])->name('staff.schools.inactive');
    Route::get('/schools/pending', [StaffController::class, 'pendingSchools'])->name('staff.schools.pending');
    Route::get('/schools/rejected', [StaffController::class, 'rejectedSchools'])->name('staff.schools.rejected');
    Route::get('/schools/create', [StaffController::class, 'createSchool'])->name('staff.schools.create');
    Route::post('/schools/store', [StaffController::class, 'storeSchool'])->name('staff.schools.store');
    Route::get('/schools/{id}/edit', [StaffController::class, 'editSchool'])->name('staff.schools.edit');
    Route::post('/schools/{id}/update', [StaffController::class, 'updateSchool'])->name('staff.schools.update');
    Route::get('/schools/{id}/delete', [StaffController::class, 'deleteSchool'])->name('staff.schools.delete');
    Route::get('/schools/{id}/activate', [StaffController::class, 'activateSchool'])->name('staff.schools.activate');
    Route::get('/schools/{id}/deactivate', [StaffController::class, 'deactivateSchool'])->name('staff.schools.deactivate');
    Route::get('/schools/{id}/approve', [StaffController::class, 'approveSchool'])->name('staff.schools.approve');
    Route::get('/schools/{id}/reject', [StaffController::class, 'rejectSchool'])->name('staff.schools.reject');
    Route::get('/schools/{id}/view', [StaffController::class, 'viewSchool'])->name('staff.schools.view');

    // Profile Management
    Route::get('/profile', [StaffController::class, 'profile'])->name('staff.profile');
    Route::put('/profile/update', [StaffController::class, 'updateProfile'])->name('staff.profile.update');

    // Exam Questions Management
    Route::get('/exam/questions', [StaffExamController::class, 'index'])->name('staff.exam.questions');
    Route::get('/exam/questions/filtered', [StaffExamController::class, 'filteredQuestions'])->name('staff.exam.questions.filtered');
    Route::get('/exam/question/create', [StaffExamController::class, 'createQuestion'])->name('staff.exam.create-question');
    Route::post('/exam/question/store', [StaffExamController::class, 'storeQuestion'])->name('staff.exam.store-question');
    Route::get('/exam/question/{id}/edit', [StaffExamController::class, 'editQuestion'])->name('staff.exam.edit-question');
    Route::post('/exam/question/{id}', [StaffExamController::class, 'updateQuestion'])->name('staff.exam.update-question');
    Route::get('/exam/question/{id}/delete', [StaffExamController::class, 'deleteQuestion'])->name('staff.exam.delete-question');
    Route::post('/exam/question/{id}/approve', [StaffExamController::class, 'approveQuestion'])->name('staff.exam.approve-question');

    // Exam Management
    Route::get('/exams', [StaffExamController::class, 'exams'])->name('staff.exams');
    Route::get('/exam/create', [StaffExamController::class, 'createExam'])->name('staff.exam.create');
    Route::post('/exam/store', [StaffExamController::class, 'storeExam'])->name('staff.exam.store');
    Route::get('/exam/{exam}/edit', [StaffExamController::class, 'editExam'])->name('staff.exam.edit');
    Route::put('/exam/{exam}/update', [StaffExamController::class, 'updateExam'])->name('staff.exam.update');
    Route::delete('/exam/{exam}/delete', [StaffExamController::class, 'deleteExam'])->name('staff.exam.delete');

    // Exam Sheet Management
    Route::get('/exam/{exam}/questions', [StaffExamController::class, 'examQuestions'])->name('staff.exam.questions.list');
    Route::post('/exam/{exam}/questions/add', [StaffExamController::class, 'addQuestionToExam'])->name('staff.exam.questions.add');
    Route::delete('/exam/{exam}/questions/{question}', [StaffExamController::class, 'removeQuestionFromExam'])->name('staff.exam.questions.remove');

    // Other Routes
    Route::get('/schools', [StaffController::class, 'schools'])->middleware('staff')->name('staff.schools');
    Route::get('/schools/active', [StaffController::class, 'activeSchools'])->middleware('staff')->name('staff.schools.active');
    Route::post('/schools', [StaffController::class, 'addSchool'])->middleware('staff')->name('staff.school.add');
    Route::get('/schools/delete/{id}', [StaffController::class, 'deleteSchool'])->middleware('staff')->name('staff.deleteSchool');
    Route::get('/schools/deactivate/{id}', [StaffController::class, 'deactivateSchool'])->middleware('staff')->name('staff.deactivateSchool');
    Route::get('/schools/activate/{id}', [StaffController::class, 'activateSchool'])->middleware('staff')->name('staff.activateSchool');

    Route::get('/schools/edit/{id}', [StaffController::class, 'editSchool'])->middleware('staff')->name('staff.schooldetail');
    Route::post('/schools/update/{id}', [StaffController::class, 'updateSchool'])->middleware('staff')->name('staff.updateSchool');
    Route::get('/school-managers', [StaffController::class, 'schoolManagers'])->middleware('staff')->name('staff.schoolManagers');
    Route::post('/school-managers', [StaffController::class, 'addSchoolManager'])->middleware('staff')->name('staff.addManager');
    Route::get('/teachers', [StaffController::class, 'teachers'])->middleware('staff')->name('staff.teachers');
    Route::get("/students", [StaffController::class, 'students'])->middleware('staff')->name('staff.students');
    Route::get("/managers", [StaffController::class, 'schoolManagers'])->middleware('staff')->name('staff.managers');
    Route::get("s", [StaffController::class, 'staffs'])->middleware('staff')->name('staff.staffs');
    Route::get("/all", [StaffController::class, 'allusers'])->middleware('staff')->name('staff.allusers');
    Route::get("/edit-user/{id}", action: [StaffController::class, 'editUser'])->middleware('staff')->name('staff.editUser');
    Route::post("/edit-user/{id}", action: [StaffController::class, 'updateUserdata'])->middleware('staff')->name('staff.editUser');
    Route::get("/subjects", [StaffController::class, 'allSubjects'])->middleware('staff')->name('staff.subjects.all');
    Route::post("/subjects", [StaffController::class, 'addSubject'])->middleware('staff')->name('staff.subjects.add');
    Route::get("/subject/{id}", [StaffController::class, 'subjectDetail'])->middleware('staff')->name('staff.subject.detail');
    Route::post("/subject/{id}", [StaffController::class, 'updateSubject'])->middleware('staff')->name('staff.subjects.update');
    Route::get("/subjects/create", [StaffController::class, 'createSubjectView'])->middleware('staff')->name('staff.subjects.create.view');
    Route::get("/subjects/edit/{id}", [StaffController::class, 'editSubject'])->middleware('staff')->name('staff.subjects.edit');
    Route::post("/subjects/create", [StaffController::class, 'addSubject'])->middleware('staff')->name('staff.subjects.create');
    Route::get("/lessons", [StaffController::class, 'allLessons'])->middleware('staff')->name('staff.lessons.all');
    Route::get("/lessons/new", [StaffController::class, 'newLesson'])->middleware('staff')->name('staff.lessons.add');
    Route::post("/lessons/add", [StaffController::class, 'addLesson'])->middleware('staff')->name('staff.lessons.addLesson');
    Route::post('/lessonImage', [TinyMCEController::class, 'uploadImage'])->name('tinymce.upload');
    Route::get("/lessons/edit/{id}", [StaffController::class, 'lessonDetail'])->middleware('staff')->name('staff.lessons.detail');
    Route::post("/lessons/edit/{id}", [StaffController::class, 'editLesson'])->middleware('staff')->name('staff.lessons.editLesson');
    Route::get("/exam/question/all", [StaffController::class, 'allQuestions'])->middleware('staff')->name('staff.questions.all');
    Route::get("/exam/question/new", [StaffController::class, 'newQuestion'])->middleware('staff')->name('staff.questions.new');
    Route::post("/exam/question/new", [StaffController::class, 'addQuestion'])->middleware('staff')->name('staff.questions.add');
    Route::get("/exam/question/edit/{id}", [StaffController::class, 'editQuestion'])->middleware('staff')->name('staff.questions.edit');
    Route::post("/exam/question/edit/{id}", [StaffController::class, 'updateQuestion'])->middleware('staff')->name('staff.questions.update');
    Route::get('/exam/all', [StaffController::class, 'allExams'])->middleware('staff')->name('staff.exams.all');
    Route::get('/exam/new', [StaffController::class, 'newExam'])->middleware('staff')->name('staff.exams.new');
    Route::post('/exam/new', [StaffController::class, 'addExam'])->middleware('staff')->name('staff.exams.add');
    Route::get('/exam/edit/{id}', [StaffController::class, 'editExam'])->middleware('staff')->name('staff.exams.edit');
    Route::post('/exam/edit/{id}', [StaffController::class, 'updateExam'])->middleware('staff')->name('staff.exams.update');
    Route::post('/examsheet/add-question', [StaffController::class, 'addQuestionToExam'])->middleware('staff')->name('staff.exams.addQuestion');
    Route::get('/examsheet/questions/{examId}', [StaffController::class, 'getExamQuestions'])->middleware('staff')->name('staff.examsheet.questions');
    Route::delete('/exams/{exam}/removeQuestion/{question}', [StaffController::class, 'removeQuestion'])->name('staff.exams.removeQuestion');
    Route::get("question/{id}/approve", [StaffController::class, 'approveQuestion'])->middleware('staff')->name('staff.questions.approve');
    Route::get("question/{id}/reject", [StaffController::class, 'rejectQuestion'])->middleware('staff')->name('staff.questions.reject');
    Route::get('/profile', [StaffController::class, 'profile'])->name('staff.profile');
    Route::put('/profile/update', [StaffController::class, 'updateProfile'])->name('staff.profile.update');

    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard');
        
        // Exam Questions Routes
        Route::prefix('exam')->group(function () {
            Route::get('/questions', [StaffExamController::class, 'index'])->name('staff.exam.questions');
            Route::get('/question/create', [StaffExamController::class, 'createQuestion'])->name('staff.exam.create-question');
            Route::post('/question/store', [StaffExamController::class, 'storeQuestion'])->name('staff.exam.store-question');
            Route::get('/question/{id}/edit', [StaffExamController::class, 'editQuestion'])->name('staff.exam.edit-question');
            Route::post('/question/{id}', [StaffExamController::class, 'updateQuestion'])->name('staff.exam.update-question');
            Route::get('/question/{id}/delete', [StaffExamController::class, 'deleteQuestion'])->name('staff.exam.delete-question');
            Route::post('/question/{id}/approve', [StaffExamController::class, 'approveQuestion'])->name('staff.exam.approve-question');
        });
    });
});
