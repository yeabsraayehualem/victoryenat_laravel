<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StudentExamHistoryController extends Controller
{
    public function upcomingExams()
    {
        $upcomingExams = Exam::where('date', '>', Carbon::now())
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->with('subject')
            ->get();

        return view('students.exam.upcoming', compact('upcomingExams'));
    }

    public function pastExams()
    {
        $pastExams = Exam::where('date', '<', Carbon::now())
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->with(['subject', 'studentAnswers' => function($query) {
                $query->where('student_id', auth()->id());
            }])
            ->get();

        return view('students.exam.past', compact('pastExams'));
    }
}
