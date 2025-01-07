<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeacherController;
Route::prefix('teacher')->middleware('teacher')->group(function() {
    Route::get('/dashboard',[TeacherController::class,'dashboard'])->name('teacher.dashboard');
});