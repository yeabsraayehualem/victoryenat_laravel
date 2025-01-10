<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamSheet;
use App\Models\Question;
use App\Models\StudentAnswer;
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
        $exam = Exam::findOrFail($examId);
        
        // Verify exam is still available
        if (!$exam->isAvailableForStudent()) {
            return redirect()->route('student.dashboard')->with('error', 'Exam time has expired.');
        }

        // Process answers and calculate score
        $answers = $request->input('answers', []);
        $correctAnswers = 0;
        $totalQuestions = count($answers);

        foreach ($answers as $questionId => $answer) {
            $question = Question::find($questionId);
            $isCorrect = $question && $question->answer == $answer;
            
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

        $score = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;

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
        $correctAnswers = StudentAnswer::where('student_id', $studentId)
            ->where('exam_id', $exam->id)
            ->where('correct', true)
            ->count();

        return [
            'total_questions' => $totalQuestions,
            'correct_answers' => $correctAnswers,
            'percentage' => $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0
        ];
    }
}
