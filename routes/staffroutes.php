<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;

Route::prefix('staff')->middleware('staff')->group(function () {
   Route::get('/dashboard', [StaffController::class, 'dashboard'])->middleware('staff')->name('staff.dashboard');
    Route::get('/schools', [StaffController::class, 'schools'])->middleware('staff')->name('staff.schools');
    Route::get('/schools/active', [StaffController::class, 'activeSchools'])->middleware('staff')->name('staff.schools.active');
    Route::post('/schools', [StaffController::class, 'addSchool'])->middleware('staff')->name('staff.addSchool');
    Route::get('/schools/delete/{id}', [StaffController::class, 'deleteSchool'])->middleware('staff')->name('staff.deleteSchool');
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
    Route::get("/subject/{id}", [StaffController::class, 'subjectDetail'])->middleware('staff')->name('staff.subjectdetail');
    Route::post("/subject/{id}", [StaffController::class, 'editSubject'])->middleware('staff')->name('staff.subject.edit');
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
});
