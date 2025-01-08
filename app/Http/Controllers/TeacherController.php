<?php


namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Question;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
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
        $student->role= "teacher";
        $student->password = Hash::make($request->password);

        $student->save();

        return redirect('/login')
            ->with('success', 'Student registered successfully!');
    }


    public function dashboard(Request $req){

      $teacherSubjects = Teacher::where('user_id', auth()->user()->id)->get();
      $grades = $teacherSubjects->pluck('subject.grade')->unique();
      $noOfUser = User::whereIn('grade', $grades)->get()->count();
      $postedQuestions = Question::where('user_id', auth()->user()->id)->get();
      $acceptedQuestions = Question::where('user_id', auth()->user()->id)->where('is_school_approved', 1)->get();

      return view('teachers.dashboard', [
        'subjects' => $teacherSubjects->count(),
        'noOfUser' => $noOfUser,
        'postedQuestions' => $postedQuestions->count(),
        'acceptedQuestions' => $acceptedQuestions->count()
      ]);
    }

    public function questionperMonth(){
      $questions = Question::where('user_id', auth()->user()->id)
      ->get()
      ->map(function($item){
        return [
          'month' => date('m', strtotime($item->created_at)),
          'posted' => Question::where('user_id', auth()->user()->id)->whereMonth('created_at', date('m', strtotime($item->created_at)))->count(),
          'school_accepted' => Question::where('user_id', auth()->user()->id)->where('is_victory_approved', 0)->where('is_school_approved', 1)->whereMonth('created_at', date('m', strtotime($item->created_at)))->count(),
          'victory_accepted' => Question::where('user_id', auth()->user()->id)->where('is_victory_approved', 1)->whereMonth('created_at', date('m', strtotime($item->created_at)))->count(),
          'total' => Question::where('user_id', auth()->user()->id)->count(),
          'accepted' => Question::where('user_id', auth()->user()->id)->where('is_victory_approved', 1)->count(),
        ];
      })
      ->groupBy('month')
      ->map(function($item){
        return [
          'month' => $item->first()->month,
          'posted' => $item->sum('posted'),
          'school_accepted' => $item->sum('school_accepted'),
          'victory_accepted' => $item->sum('victory_accepted'),
        ];
      });

      return response()->json($questions);

    }

    public function teacherSubjects(Request $req){
      $teacherSubjects = Teacher::where('user_id', auth()->user()->id)->get();

      return view('teachers.subjects', ['subjects' => $teacherSubjects]);
    }

    public function subjectDetail(Request $req, $subject){
      $subject = Subject::find($subject);
      $students = User::where('grade', $subject->grade)->where('role', 'student')->get();
      return view('teachers.subjectDetail', ['subject' => $subject, 'students' => $students]);
    }


    public function addQuestion(Request $req){
        $validator = Validator::make($req->all(), [
            'question' => 'required',
            'option1' => 'required',
            'option2' => 'required',
            'option3' => 'required',
            'option4' => 'required',
            'answer' => 'required',
            'subject_id' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $question = new Question();
        $question->question = $req->question;
        $question->option1 = $req->option1;
        $question->option2 = $req->option2;
        $question->option3 = $req->option3;
        $question->option4 = $req->option4;
        $question->answer = $req->answer;
        $question->subject_id = $req->subject_id;
        $question->user_id = auth()->user()->id;
        $question->save();

        return redirect()->route('teacher.questions');
    }
public function newQuestion(){
    $teacherSubjects = Teacher::where('user_id', auth()->user()->id)->get()->pluck('subject_id');
    $subjects = Subject::whereIn('id', $teacherSubjects)->get();
    return view('teachers.addQuestion', ['subjects' => $subjects]);
}
    public function editQuestion(Request $req, $id){
        $validator = Validator::make($req->all(), [
            'question' => 'required',
            'option1' => 'required',
            'option2' => 'required',
            'option3' => 'required',
            'option4' => 'required',
            'answer' => 'required',
            'subject_id' => 'required',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $question = Question::find($id);
        $question->question = $req->question;
        $question->option1 = $req->option1;
        $question->option2 = $req->option2;
        $question->option3 = $req->option3;
        $question->option4 = $req->option4;
        $question->answer = $req->answer;
        $question->subject_id = $req->subject_id;
        $question->user_id = auth()->user()->id;
        $question->save();

        return redirect()->route('teacher.questions');
    }

    public function questionDetail($id){
        $question = Question::find($id);
        $teacherSubjects = Teacher::where('user_id', auth()->user()->id)->get()->pluck('subject_id');
        $subjects = Subject::whereIn('id', $teacherSubjects)->get();        return view('teachers.question_detail', ['question' => $question, 'subjects' => $subjects]);
    }
    public function questions(){
        $questions = Question::where('user_id', auth()->user()->id)->get();
        return view('teachers.questions', ['questions' => $questions]);
    }

    public function upcomingExams(Request $req){
        $teacherSubjects = Teacher::where('user_id', auth()->user()->id)->get()->pluck('subject_id');
        $exams = Exam::whereIn('subject_id', $teacherSubjects)->whereBetween('date', [now(), now()->addMonth()])->get();
        $isFuture = true;
        return view('teachers.exams', ['exams' => $exams, 'isFuture' => $isFuture]);
    }

    public function pastExams(Request $req){
        $teacherSubjects = Teacher::where('user_id', auth()->user()->id)->get()->pluck('subject_id');
        $exams = Exam::whereIn('subject_id', $teacherSubjects)->where('date', '<', now())->get();
        $isFuture = false;
        return view('teachers.exams', ['exams' => $exams, 'isFuture' => $isFuture]);
    }

    public function examDetail(Request $req,$id){

    }


}
