<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Store a newly created student in the database.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15',
            'school' => 'nullable|string|max:255',
            'grade' => 'nullable|integer|min:1|max:12',
            'password' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the student record
        $student = new User();
        $student->first_name = $request->first_name;
        $student->last_name = $request->last_name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->school_id = $request->school;
        $student->grade = $request->grade;
        $student->role = "student";
        $student->password = Hash::make($request->password);

        $student->save();

        return redirect('/')
            ->with('success', 'Student registered successfully!');
    }

    public function dashboard(Request $req)
    {

        return view('students.dashboard');
    }

    public function examSchedules()
    {
        $exams = Exam::query()
            ->whereDate('date', '>=', now()->toDateString())
            ->whereRelation('subject', 'grade', auth()->user()->grade)
            ->with('subject')
            ->get()
            ->map(function ($exam) {
                return [
                    'id' => $exam->id,
                    'date' => $exam->date,
                    'time' => $exam->time,
                    'subject' => $exam->subject->name ?? 'Unknown Subject',
                    'url' => url('student/exam-detail/' . $exam->id),
                ];
            });

        return response()->json([
            'status' => 'success',
            'data' => $exams,
        ]);
    }

    public function examDetail(Request $req, $id){
        $exam = Exam::find($id);
        return view('students.examDetail',['exam' => $exam]);

    }

    public function subjects(Request $req){
        $subjects = Subject::where('grade', auth()->user()->grade)->get();

        return view('students.subjects', ['subjects' => $subjects]);
    }
    public function lessons(Request $req, $id)
    {
        $lessons = Lesson::where('subject_id', $id)->get();
    
        if ($lessons->isEmpty()) {
            return redirect()->back()->with('error', 'No lessons found for this subject.');
        }
    
        return view('students.lessons', ['lessons' => $lessons]);
    }

    public function lessonDetail(Request $req, $id, $subId)
    {
        // Fetch a single lesson by ID
        $lesson = Lesson::where('id', $subId)->first();
    
        // Ensure the lesson exists before passing to the view
        if (!$lesson) {
            return redirect()->back()->with('error', 'Lesson not found.');
        }
    
        // Pass the lesson to the view
        return view('students.lessonDetail', ['lesson' => $lesson]);
    }

    public function upcomingExams()
    {
        $upcomingExams = Exam::where('date', '>', now())
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->with('subject')
            ->get();

        return view('students.exam.upcoming', compact('upcomingExams'));
    }

    public function pastExams()
    {
        $pastExams = Exam::where('date', '<', now())
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->with(['subject', 'studentAnswers' => function($query) {
                $query->where('student_id', auth()->id());
            }])
            ->get();

        return view('students.exam.past', compact('pastExams'));
    }
}
