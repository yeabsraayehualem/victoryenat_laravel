<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\School;
use App\Models\User;
use App\Models\Exam;
use App\Models\Question;

class SchoolManagersContrller extends Controller
{
    public function index(Request $request)
    { 
        // schoolId = Auth::user()->school_id;
        // $school = School::where('id', $schoolId)->first();
        $userCounts = User::where('school_id', auth()->user()->school_id)->count();
        $totalStudents = User::where('school_id', auth()->user()->school_id)->where('role', 'student')->count();
        $totalTeachers = User::where('school_id', auth()->user()->school_id)->where('role', 'teacher')->count();
        $activeStudents = User::where('school_id', auth()->user()->school_id)->where('role', 'student')->where('status', 'active')->count();
        $activeTeachers = User::where('school_id', auth()->user()->school_id)->where('role', 'teacher')->where('status', 'active')->count();
        $upcomingExams = Exam::whereBetween('date', [now(), now()->addWeeks(2)])->orderBy('date')->get();

        return view('manager.dashboard',['totalUsers'=>$userCounts,'totalStudents'=>$totalStudents,'totalTeachers'=>$totalTeachers,'activeStudents'=>$activeStudents,'activeTeachers'=>$activeTeachers,'upcomingExams'=>$upcomingExams]);
    }
    public function getUserData()
    {
        $roles = ['student', 'teacher', 'school_manager'];
        $monthlyData = [];
    
        foreach ($roles as $role) {
            $userCounts = User::selectRaw('strftime("%m", created_at) as month, COUNT(*) as count')
                ->where('role', $role)->where('school_id', auth()->user()->school_id)
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('count', 'month');
    
            $monthlyData[$role] = array_fill(0, 12, 0);
    
            foreach ($userCounts as $month => $count) {
                $monthlyData[$role][(int)$month - 1] = $count; 
            }
        }
    
        return response()->json($monthlyData);
    }

    public function getActiveTeachers()
    {
        $schoolId = auth()->user()->school_id;
        $teachers = User::where('school_id', $schoolId)->where('role', 'teacher')->where('status', 'active')->get();
        return view('manager.teachers', ['teachers' => $teachers]);
    }

    public function getNewTeachers()
    {
        $schoolId = auth()->user()->school_id;
        $teachers = User::where('school_id', $schoolId)->where('role', 'teacher')->where('status', 'inactive')->get();
        return view('manager.teachers', ['teachers' => $teachers]);
    }

    public function activateTeacher(Request $request,$id)
    {
        
        $user = User::where('id',$id)->first();
        if ($user->status == 'active') {
            $user->status = 'inactive';
            $user->save();
            return view('manager.dashboard', ['message' => 'Teacher deactivated successfully']);
        }
        $user->status = 'active';
        $user->save();
        return redirect()->route('manager.dashboard', ['message' => 'Teacher activated successfully']);

    }

    public function getActiveStudents()
    {
        $schoolId = auth()->user()->school_id;
        $students = User::where('school_id', $schoolId)->where('role', 'student')->where('status', 'active')->get();
        return view('manager.students', ['students' => $students]);
    }

    public function getNewStudents()
    {
        $schoolId = auth()->user()->school_id;
        $students = User::where('school_id', $schoolId)->where('role', 'student')->where('status', 'inactive')->get();
        return view('manager.students', ['students' => $students]);
    }

    public function activateStudent(Request $request, $id)
    {
        $user = User::find($id);
        if ($user->status == 'active') {
            $user->status = 'inactive';
            $user->save();
            return redirect()->route('manager.dashboard', ['message' => 'Student activated successfully']);
        }
        $user->status = 'active';
        $user->save();
        return  redirect()-> route('manager.dashboard', ['message' => 'Student activated successfully']);
    }

    public function userDetail(Request $request,$id)
    {   
        $user = User::find($id);
        return view('manager.user_detail', ['user' => $user]);
    }

    public function examslist()
    {
        $schoolId = auth()->user()->school_id;
        $exams = Exam::whereBetween('date', [now(), now()->addWeeks(6)])->orderBy('date')->get();
        return view('manager.exams', ['exams' => $exams]);
    }
    
    public function getExamQuestions(Request $request)
    {
        $schoolId = auth()->user()->school_id;
        $questions = Question::whereHas('user', function ($query) use ($schoolId) {
            $query->where('school_id', $schoolId);
        })->get();
        return view('manager.questions', ['questions' => $questions]);
    }
    public function questionDetail(Request $request,$id)
    {
        $question = Question::find($id);
        return view('manager.questionDetail', ['question' => $question]);
    }

    public function approveQuestion(Request $request,$id)
    {
        $question = Question::find($id);
        $question->is_school_approved = 1;
        $question->save();
        return redirect()->route('manager.questions');
    }
    public function rejectQuestion(Request $request,$id)
    {
        $question = Question::find($id);
        $question->is_school_approved = 0;
        $question->is_victory_approved = 0;
        $question->save();
        return redirect()->route('manager.questions');
    }
    
}
