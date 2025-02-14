<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamSheet;
use App\Models\Question;
use App\Models\StudentAnswer;
use App\Models\StudentResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Mews\Purifier\Facades\Purifier;

class ExamController extends Controller
{
    public function start($examId)
    {
        $exam = Exam::with(['examSheets.question'])->findOrFail($examId);
        
        // Check if exam is available
        if (!$exam->isAvailableForStudent()) {
            return redirect()->back()->with('error', 'This exam is not currently available.');
        }

        // Check if student has already taken the exam
        if ($exam->studentAnswers()->where('student_id', auth()->id())->exists()) {
            return redirect()->back()->with('error', 'You have already taken this exam.');
        }

        // Clean HTML content
        foreach ($exam->examSheets as $sheet) {
            $sheet->question->question = Purifier::clean($sheet->question->question);
            $sheet->question->option1 = Purifier::clean($sheet->question->option1);
            $sheet->question->option2 = Purifier::clean($sheet->question->option2);
            $sheet->question->option3 = Purifier::clean($sheet->question->option3);
            $sheet->question->option4 = Purifier::clean($sheet->question->option4);
        }

        return view('students.exam.take', compact('exam'));
    }

    public function submit(Request $request, $examId)
    {
        $exam = Exam::with('examSheets.question')->findOrFail($examId);
        
        // Verify exam is still available
        if (!$exam->isAvailableForStudent()) {
            return redirect()->route('student.dashboard')->with('error', 'Exam time has expired.');
        }

        // Process answers and calculate score
        $answers = $request->input('answers', []);
        $correctAnswers = 0;
        $totalQuestions = $exam->examSheets()->count();
        $marksPerQuestion = $exam->total_marks / $totalQuestions;

        foreach ($answers as $questionId => $answer) {
            $examSheet = $exam->examSheets->firstWhere('question_id', $questionId);
            if (!$examSheet) {
                continue;
            }

            $question = $examSheet->question;
            $isCorrect = $question->checkAnswer($answer);
            
            StudentAnswer::create([
                'student_id' => auth()->id(),
                'exam_id' => $examId,
                'question' => $questionId,
                'answer' => $answer,
                'correct' => $isCorrect
            ]);

            if ($isCorrect) {
                $correctAnswers++;
            }
        }

        // Calculate total score
        $score = ($correctAnswers * $marksPerQuestion);
        $percentage = ($score / $exam->total_marks) * 100;
        
        // Record the result
        $studentResult = new StudentResult([
            'student_id' => auth()->id(),
            'exam_id' => $examId,
            'result' => $score,
            'pass_fail' => $score >= $exam->passing_marks
        ]);
        $studentResult->save();

        return redirect()->route('student.exam.result', $examId)
            ->with('success', 'Exam submitted successfully!');
    }

    public function result($examId)
    {
        $exam = Exam::with(['examSheets.question'])->findOrFail($examId);
        
        // Get student's answers
        $studentAnswers = StudentAnswer::where('student_id', Auth::id())
            ->where('exam_id', $examId)
            ->get()
            ->keyBy('question');
            
        // Calculate score
        $score = $this->calculateScore($exam, Auth::id());
        
        // Clean HTML content
        foreach ($exam->examSheets as $sheet) {
            $sheet->question->question = Purifier::clean($sheet->question->question);
            $sheet->question->option1 = Purifier::clean($sheet->question->option1);
            $sheet->question->option2 = Purifier::clean($sheet->question->option2);
            $sheet->question->option3 = Purifier::clean($sheet->question->option3);
            $sheet->question->option4 = Purifier::clean($sheet->question->option4);
        }

        return view('students.exam.result', compact('exam', 'score', 'studentAnswers'));
    }

    private function calculateScore($exam, $studentId)
    {
        $totalQuestions = $exam->examSheets()->count();
        $marksPerQuestion = $exam->total_marks / $totalQuestions;
        
        $correctAnswers = StudentAnswer::where('student_id', $studentId)
            ->where('exam_id', $exam->id)
            ->where('correct', true)
            ->count();

        $score = $correctAnswers * $marksPerQuestion;
        $percentage = ($score / $exam->total_marks) * 100;

        return [
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'score' => $score,
            'total_marks' => $exam->total_marks,
            'passing_marks' => $exam->passing_marks,
            'percentage' => $percentage,
            'passed' => $score >= $exam->passing_marks
        ];
    }
}
