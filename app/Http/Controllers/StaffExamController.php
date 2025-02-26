<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Subject;
use App\Models\School;
use App\Models\Exam;
use App\Models\ExamSheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StaffExamController extends Controller
{
    public function index(Request $request)
    {
        $query = Question::with(['subject', 'user'])
            ->when($request->filled('subject'), function($q) use ($request) {
                return $q->where('subject_id', $request->subject);
            })
            ->when($request->filled('chapter'), function($q) use ($request) {
                return $q->where('chapter', $request->chapter);
            })
            ->when($request->filled('school'), function($q) use ($request) {
                return $q->whereHas('user', function($query) use ($request) {
                    $query->where('school_id', $request->school);
                });
            })
            ->when($request->filled('status'), function($q) use ($request) {
                return match($request->status) {
                    'pending' => $q->where('is_victory_approved', false)->where('is_school_approved', false),
                    'school_approved' => $q->where('is_victory_approved', false)->where('is_school_approved', true),
                    'victory_approved' => $q->where('is_victory_approved', true),
                    default => $q
                };
            })
            ->latest();

        $questions = $query->paginate(10)->withQueryString();
        
        // Get unique chapters for filter
        $chapters = Question::distinct()->pluck('chapter')->sort()->values();
        
        // Get subjects and schools for filters
        $subjects = Subject::orderBy('name')->get();
        $schools = School::orderBy('name')->get();

        if ($request->header('HX-Request')) {
            return view('staff.exam.partials.questions-table', compact('questions'));
        }

        return view('staff.exam.index', compact('questions', 'subjects', 'chapters', 'schools'));
    }

    public function createQuestion()
    {
        $subjects = Subject::all();
        return view('staff.exam.new.create-question', compact('subjects'));
    }

    public function storeQuestion(Request $request)
    {
        try {
            $validated = $request->validate([
                'question' => 'required|string',
                'option1' => 'required|string',
                'option2' => 'required|string',
                'option3' => 'required|string',
                'option4' => 'required|string',
                'answer' => 'required|in:a,b,c,d',
                'subject_id' => 'required|exists:subjects,id',
                'chapter' => 'required|string'
            ]);

            $question = Question::create([
                ...$validated,
                'user_id' => Auth::id(),
                'is_school_approved' => false,
                'is_victory_approved' => false
            ]);

            if ($request->header('HX-Request')) {
                return view('staff.exam.new.partials.question-success', compact('question'));
            }

            return redirect()
                ->route('staff.exam.create-question')
                ->with('success', 'Question created successfully!')
                ->with('question', $question);

        } catch (\Exception $e) {
            if ($request->header('HX-Request')) {
                return response()->json([
                    'error' => 'Failed to create question. Please try again.'
                ], 422);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to create question. Please try again.');
        }
    }

    public function deleteQuestion($id)
    {
        try {
            $question = Question::findOrFail($id);
            $question->delete();

            return redirect()
                ->route('staff.exam.questions')
                ->with('success', 'Question deleted successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to delete question. Please try again.');
        }
    }

    public function editQuestion($id)
    {
        $question = Question::findOrFail($id);
        $subjects = Subject::all();
        return view('staff.exam.edit-question', compact('question', 'subjects'));
    }

    public function updateQuestion(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        
        $validated = $request->validate([
            'question' => 'required',
            'option1' => 'required',
            'option2' => 'required',
            'option3' => 'required',
            'option4' => 'required',
            'answer' => 'required|in:a,b,c,d',
            'subject_id' => 'required|exists:subjects,id',
            'chapter' => 'required',
        ]);

        $question->update($validated);

        return back()->with('success', 'Question updated successfully');
    }

    public function approveQuestion($id)
    {
        try {
            $question = Question::findOrFail($id);
            
            // Check if already approved
            if ($question->is_victory_approved) {
                return response()->json([
                    'success' => false,
                    'message' => 'This question has already been approved.',
                    'details' => [
                        'current_status' => 'approved',
                        'approved_at' => $question->approved_at?->format('Y-m-d H:i:s'),
                        'approved_by' => $question->approved_by
                    ]
                ], 400);
            }

            $now = now();

            // Update approval status
            $updated = $question->update([
                'is_school_approved' => true,
                'is_victory_approved' => true,
                'approved_at' => $now,
                'approved_by' => auth()->id()
            ]);

            if (!$updated) {
                throw new \Exception('Database update failed. Please try again.');
            }

            // Refresh the model to get updated attributes
            $question->refresh();

            // Verify the update
            if (!$question->is_victory_approved) {
                throw new \Exception('Update verification failed. The approval status was not saved correctly.');
            }

            // Log the approval
            \Log::info('Question approved successfully', [
                'question_id' => $id,
                'approved_by' => auth()->id(),
                'is_school_approved' => $question->is_school_approved,
                'is_victory_approved' => $question->is_victory_approved,
                'approved_at' => $now->format('Y-m-d H:i:s')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Question approved successfully',
                'status' => [
                    'is_school_approved' => $question->is_school_approved,
                    'is_victory_approved' => $question->is_victory_approved,
                    'approved_at' => $now->format('Y-m-d H:i:s')
                ]
            ]);

        } catch (\Exception $e) {
            $errorMessage = 'Approval failed: ';
            
            if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                $errorMessage .= 'Question not found.';
            } else {
                $errorMessage .= $e->getMessage();
            }

            \Log::error($errorMessage, [
                'question_id' => $id,
                'user_id' => auth()->id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => $errorMessage,
                'details' => [
                    'error_type' => get_class($e),
                    'error_message' => $e->getMessage()
                ]
            ], 500);
        }
    }

    public function exams(Request $request)
    {
        $query = Exam::with(['subject'])
            ->when($request->filled('subject'), function($q) use ($request) {
                return $q->where('subject_id', $request->subject);
            })
            ->when($request->filled('status'), function($q) use ($request) {
                $now = now();
                return match($request->status) {
                    'upcoming' => $q->where('date', '>', $now->format('Y-m-d')),
                    'ongoing' => $q->where('date', $now->format('Y-m-d'))->where(function($q) use ($now) {
                        $q->whereRaw("CONCAT(date, ' ', time) <= ?", [$now->format('Y-m-d H:i:s')])
                          ->whereRaw("DATE_ADD(CONCAT(date, ' ', time), INTERVAL duration MINUTE) >= ?", [$now->format('Y-m-d H:i:s')]);
                    }),
                    'completed' => $q->where(function($q) use ($now) {
                        $q->where('date', '<', $now->format('Y-m-d'))
                          ->orWhere(function($q) use ($now) {
                              $q->where('date', $now->format('Y-m-d'))
                                ->whereRaw("DATE_ADD(CONCAT(date, ' ', time), INTERVAL duration MINUTE) < ?", [$now->format('Y-m-d H:i:s')]);
                          });
                    }),
                    default => $q
                };
            })
            ->latest('date');

        $exams = $query->paginate(10)->withQueryString();
        $subjects = Subject::orderBy('name')->get();

        if ($request->header('HX-Request')) {
            return view('staff.exam.partials.exams-table', compact('exams'));
        }

        return view('staff.exam.exams', compact('exams', 'subjects'));
    }

    public function createExam()
    {
        $subjects = Subject::orderBy('name')->get();
        return view('staff.exam.create-exam', compact('subjects'));
    }

    public function storeExam(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'duration' => 'required|integer|min:1',
            'total_marks' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:1|lte:total_marks',
        ]);

        try {
            $exam = Exam::create($validated);
            
            if ($request->header('HX-Request')) {
                return response()
                    ->view('staff.exam.partials.exam-success', [
                        'message' => 'Exam created successfully!',
                        'exam' => $exam
                    ])
                    ->withHeaders([
                        'HX-Redirect' => route('staff.exams')
                    ]);
            }

            return redirect()
                ->route('staff.exams')
                ->with('success', 'Exam created successfully!');
        } catch (\Exception $e) {
            Log::error('Error creating exam: ' . $e->getMessage());
            
            if ($request->header('HX-Request')) {
                return response()
                    ->view('staff.exam.partials.exam-error', [
                        'message' => 'Error creating exam. Please try again.'
                    ], 422);
            }

            return back()
                ->withInput()
                ->with('error', 'Error creating exam. Please try again.');
        }
    }

    public function editExam(Exam $exam)
    {
        $subjects = Subject::orderBy('name')->get();
        return view('staff.exam.edit-exam', compact('exam', 'subjects'));
    }

    public function updateExam(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'duration' => 'required|integer|min:1',
            'total_marks' => 'required|integer|min:1',
            'passing_marks' => 'required|integer|min:1|lte:total_marks',
        ]);

        try {
            $exam->update($validated);
            
            if ($request->header('HX-Request')) {
                return response()
                    ->view('staff.exam.partials.exam-success', [
                        'message' => 'Exam updated successfully!',
                        'exam' => $exam
                    ])
                    ->withHeaders([
                        'HX-Redirect' => route('staff.exams')
                    ]);
            }

            return redirect()
                ->route('staff.exams')
                ->with('success', 'Exam updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating exam: ' . $e->getMessage());
            
            if ($request->header('HX-Request')) {
                return response()
                    ->view('staff.exam.partials.exam-error', [
                        'message' => 'Error updating exam. Please try again.'
                    ], 422);
            }

            return back()
                ->withInput()
                ->with('error', 'Error updating exam. Please try again.');
        }
    }

    public function deleteExam(Exam $exam)
    {
        try {
            $exam->delete();
            return response()->json(['message' => 'Exam deleted successfully']);
        } catch (\Exception $e) {
            Log::error('Error deleting exam: ' . $e->getMessage());
            return response()->json(['message' => 'Error deleting exam'], 500);
        }
    }

    public function examQuestions(Request $request, Exam $exam)
    {
        $assignedQuestions = $exam->examSheets()
            ->with('question.subject')
            ->get()
            ->pluck('question');

        $availableQuestions = Question::with('subject')
            ->where('subject_id', $exam->subject_id)
            ->whereNotIn('id', $assignedQuestions->pluck('id'))
            ->where(function($query) use ($request) {
                if ($request->filled('search')) {
                    $search = $request->search;
                    $query->where('question', 'like', "%{$search}%")
                          ->orWhere('chapter', 'like', "%{$search}%");
                }
            })
            ->get();

        if ($request->header('HX-Request')) {
            return view('staff.exam.partials.available-questions', compact('availableQuestions'));
        }

        return view('staff.exam.exam-questions', compact('exam', 'assignedQuestions', 'availableQuestions'));
    }

    public function addQuestionToExam(Request $request, Exam $exam)
    {
        try {
            $validated = $request->validate([
                'question_id' => 'required|exists:questions,id'
            ]);

            // Check if question is already assigned
            $exists = ExamSheet::where('exam_id', $exam->id)
                ->where('question_id', $validated['question_id'])
                ->exists();

            if ($exists) {
                return response()->json([
                    'message' => 'Question is already assigned to this exam'
                ], 422);
            }

            // Create exam sheet
            ExamSheet::create([
                'exam_id' => $exam->id,
                'question_id' => $validated['question_id']
            ]);

            // Get updated questions for both lists
            $assignedQuestions = $exam->examSheets()->with('question.subject')->get()->pluck('question');
            $availableQuestions = Question::with('subject')
                ->where('subject_id', $exam->subject_id)
                ->whereNotIn('id', $assignedQuestions->pluck('id'))
                ->get();

            return response()->json([
                'message' => 'Question added successfully',
                'assigned_html' => view('staff.exam.partials.assigned-questions', compact('assignedQuestions'))->render(),
                'available_html' => view('staff.exam.partials.available-questions', compact('availableQuestions'))->render()
            ]);
        } catch (\Exception $e) {
            Log::error('Error adding question to exam: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error adding question to exam'
            ], 500);
        }
    }

    public function removeQuestionFromExam(Exam $exam, Question $question)
    {
        try {
            ExamSheet::where('exam_id', $exam->id)
                ->where('question_id', $question->id)
                ->delete();

            // Get updated questions for both lists
            $assignedQuestions = $exam->examSheets()->with('question.subject')->get()->pluck('question');
            $availableQuestions = Question::with('subject')
                ->where('subject_id', $exam->subject_id)
                ->whereNotIn('id', $assignedQuestions->pluck('id'))
                ->get();

            return response()->json([
                'message' => 'Question removed successfully',
                'assigned_html' => view('staff.exam.partials.assigned-questions', compact('assignedQuestions'))->render(),
                'available_html' => view('staff.exam.partials.available-questions', compact('availableQuestions'))->render()
            ]);
        } catch (\Exception $e) {
            Log::error('Error removing question from exam: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error removing question from exam'
            ], 500);
        }
    }
}
