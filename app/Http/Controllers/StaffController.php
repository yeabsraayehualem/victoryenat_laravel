<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\School;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\Exam;
use App\Models\ExamSheet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Subject;
class StaffController extends Controller
{public function getUserData()
    {
        $roles = ['student', 'teacher', 'staff', 'school_manager'];
        $monthlyData = [];
    
        foreach ($roles as $role) {
            $userCounts = User::selectRaw('strftime("%m", created_at) as month, COUNT(*) as count')
                ->where('role', $role)
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('count', 'month');
    
            // Create an array with 12 months initialized to 0 for each role
            $monthlyData[$role] = array_fill(0, 12, 0);
    
            // Populate the data for the months with user counts
            foreach ($userCounts as $month => $count) {
                $monthlyData[$role][(int)$month - 1] = $count; // Adjust month to 0-based index
            }
        }
    
        // Return the data as a JSON response
        return response()->json($monthlyData);
    }
    
    public function getSchoolData()
    {
        $schoolCounts = School::selectRaw('strftime("%m", created_at) as month, COUNT(*) as count')
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('count', 'month');

    // Create an array with 12 months initialized to 0
    $monthlyData = array_fill(1, 12, 0);

    // Populate the data for the months with user counts
    foreach ($schoolCounts as $month => $count) {
        $monthlyData[(int)$month] = $count; // Convert month to integer to match array keys
    }

    // return $monthlyData;
    // Return the data as a JSON response
    return response()->json(array_values($monthlyData));
    }
    public function getUserByRole()
    {
        // Get user counts by role
        $userCounts = User::selectRaw('role, COUNT(*) as count')
            ->groupBy('role')
            ->pluck('count', 'role')
            ->toArray(); // Convert the result to an associative array

        // Return the data as a JSON response
        return response()->json($userCounts);
    }

    public function dashboard(Request $req)
    {
        $teachers = User::where('role', 'teacher')->get();
        $active_schools = School::where('status', 'active')->get();
        $school = School::all();
        $students = User::where('role', 'student')->get();
        $school_manager = User::where('role', 'school_manager')->get();
        $users = User::all();
        return view('staff.index',[
            'teachers' => $teachers,
            'schools' => $school,
            'students' => $students,
            'school_managers' => $school_manager,
            'users'=>$users,
            'active_schools' => $active_schools
        ]);
    }
    public function schools(Request $req)
    {
        $schools = School::all();
        return view('staff.school.all-schools', ['schools' => $schools]);
    }
    public function activeSchools(Request $req)
    {
        $schools = School::where('status', 'active')->get();
        return view('staff.school.all-schools', ['schools' => $schools]);
    }
    public function addSchool(Request $req)
    {
        $req->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'website' => 'string|nullable',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $school = new School();
        $school->name = $req->name;
        $school->website = $req->website;
        $school->email = $req->email;
        $school->address = $req->address;
        $school->phone = $req->phone;
        if ($req->hasFile('logo')) {
            $file = $req->file('logo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/schools', $fileName, 'public');
            $school->logo = $filePath;
        }

        $school->save();
        return redirect()->route('staff.schools');
    }

    public function deleteSchool(Request $req, $id)
    {
        $school = School::find($id);
        $school->delete();
        return redirect()->route('staff.schools');
    }

    public function editSchool(Request $req, $id)
    {
        $school = School::find($id);

        return view('staff.school.school-detail', ['school' => $school]);
    }

    public function updateSchool(Request $req, $id)
    {
        $req->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'website' => 'string|nullable',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            $school = School::find($id);
            $school->name = $req->name;
            $school->website = $req->website;
            $school->email = $req->email;
            $school->address = $req->address;
            $school->phone = $req->phone;
            if ($req->hasFile('logo')) {
                $file = $req->file('logo');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/schools', $fileName, 'public');
                $school->logo = $filePath;
            }

            $school->save();
            return redirect()->route('staff.schools')->with('success', 'School updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('staff.schools')->with('error', 'Error updating school: ' . $e->getMessage());
        }
    }

    public function schoolManagers(Request $req)
    {
        $schoolManagers = User::where('role', 'school_manager')->get();
        $schools = School::all();
        return view('staff.users.users', ['users' => $schoolManagers, 'schools' => $schools]);
    }


    public function teachers(Request $req)
    {
        $teachers = User::where('role', 'teacher')->get();
        return view('staff.users.users', ['users' => $teachers]);
    }

    public function students(Request $req)
    {
        $students = User::where('role', 'student')->get();
        return view('staff.users.users', ['users' => $students]);
    }

    public function staffs(Request $req)
    {
        $staffs = User::where('role', 'staff')->get();
        return view('staff.users.users', ['users' => $staffs]);
    }

    public function allusers(Request $req)
    {
        $users = User::all();
        return view('staff.users.users', ['users' => $users]);
    }

    public function editUser(Request $req, $id)
    {
        $user = User::find($id);
        $schools = School::all();
        return view('staff.users.updateUser', ['user' => $user, 'schools' => $schools]);
    }

    public function updateUserdata(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:15',
            'school' => 'nullable|string|max:255',
            'grade' => 'nullable|integer|min:1|max:12',
            'role' => 'required|string|in:student,teacher,staff,school_manager',
        ]);

        if ($validator->fails()) {

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = implode(' ', $errors);
            echo "<script>alert('Error: $errorMessage');</script>";
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        // Create the student record
        $user = User::find($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->school_id = $request->school;
        $user->grade = $request->grade;
        $user->role = $request->role;

        $user->save();

        return redirect()->route('staff.allusers')
            ->with('success', 'User updated successfully!');
    }

    public function allSubjects(Request $req)
    {
        $subjects = Subject::all();
        return view('staff.lessons.subjects', ['subjects' => $subjects]);
    }
    public function addSubject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_code' => 'required|string|max:255',
            'grade' => 'required|integer|min:1|max:12',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $subject = new Subject();
            $subject->name = $request->name;
            $subject->description = $request->description;
            $subject->shore_code = $request->short_code;
            $subject->grade = $request->grade;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/subjects', $fileName, 'public');
                $subject->image = $filePath;
            }

            $subject->save();

            return redirect()->route('staff.subjects.all')
                ->with('success', 'Subject added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to add subject: ' . $e->getMessage());
        }
    }

    public function subjectDetail(Request $req, $id)
    {
        $subject = Subject::find($id);
        $lessons = Lesson::where('subject_id', $id)->get();
        return view('staff.lessons.subject-detail', ['subject' => $subject, 'lessons' => $lessons]);
    }
    public function editSubject(Request $req, $id)
    {
        $vadidator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_code' => 'required|string|max:255',
            'grade' => 'required|integer|min:1|max:12',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($vadidator->fails()) {
            return redirect()->back()
                ->withErrors($vadidator)
                ->withInput();
        }

        try {
            $subject = Subject::find($id);
            $subject->name = $req->name;
            $subject->description = $req->description;
            $subject->shore_code = $req->short_code;
            $subject->grade = $req->grade;

            if ($req->hasFile('image')) {
                $file = $req->file('image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/subjects', $fileName, 'public');
                $subject->image = $filePath;
            }

            $subject->save();

            return redirect()->route('staff.subjects.all')
                ->with('success', 'Subject updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update subject: ' . $e->getMessage());
        }
    }

    public function allLessons(Request $request)
    {
        $lessons = Lesson::all();
        return view('staff.lessons.lessons', ['lessons' => $lessons]);
    }
    public function newLesson(Request $request)
    {
        $subjects = Subject::all();
        return view('staff.lessons.add_lesson', ['subjects' => $subjects]);
    }
    public function addLesson(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'file' => 'file|mimes:pdf,doc,docx,txt,rtf|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $lesson = new Lesson();
            $lesson->title = $request->title;
            $lesson->description = $request->description;
            $lesson->subject_id = $request->subject_id;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/lessons', $fileName, 'public');
                $lesson->image = $filePath;
            }

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/lessons', $fileName, 'public');
                $lesson->file = $filePath;
            }

            $lesson->save();

            return redirect()->route('staff.lessons.all')
                ->with('success', 'Lesson added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to add lesson: ' . $e->getMessage());
        }
    }
    public function editLesson(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'subject_id' => 'required|integer',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'file' => 'file|mimes:pdf,doc,docx,txt,rtf|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $lesson = Lesson::find($id);
            $lesson->title = $request->title;
            $lesson->description = $request->description;
            $lesson->subject_id = $request->subject_id;

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/lessons', $fileName, 'public');
                $lesson->image = $filePath;
            }

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('uploads/lessons', $fileName, 'public');
                $lesson->file = $filePath;
            }

            $lesson->save();

            return redirect()->route('staff.lessons.all')
                ->with('success', 'Lesson added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to add lesson: ' . $e->getMessage());
        }
    }

    public function lessonDetail(Request $req, $id)
    {
        $lesson = Lesson::find($id);
        $subjects = Subject::all();
        return view('staff.lessons.edit_lesson', ['lesson' => $lesson, 'subjects' => $subjects]);
    }

    public function allQuestions(Request $req)
    {
        $questions = Question::all();
        return view('staff.exam.all-questions', ['questions' => $questions]);
    }

    public function newQuestion(Request $req)
    {
        $subjects = Subject::all();
        return view('staff.exam.add-question', ['subjects' => $subjects]);
    }

    public function addQuestion(Request $req){
        $validator = Validator::make($req->all(), [
            'question' => 'required|string',
            'option1' => 'required|string',
            'option2' => 'required|string',
            'option3' => 'required|string',
            'option4' => 'required|string',
            'answer' => 'required|string',
            'subject_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
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

            return redirect()->route('staff.questions.all')
                ->with('success', 'Question added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())
                ->with('error', 'Failed to add question: ' . $e->getMessage());
        }
    }

    public function editQuestion(Request $req, $id)
    {
        $question = Question::find($id);
        $subjects = Subject::all();
        return view('staff.exam.edit-question', ['question' => $question, 'subjects' => $subjects]);
    }

    public function updateQuestion(Request $req, $id){
        $validator = Validator::make($req->all(), [
            'question' => 'required|string',
            'option1' => 'required|string',
            'option2' => 'required|string',
            'option3' => 'required|string',
            'option4' => 'required|string',
            'answer' => 'required|string',
            'subject_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
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

            return redirect()->route('staff.questions.all')
                ->with('success', 'Question updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())
                ->with('error', 'Failed to update question: ' . $e->getMessage());
        }
    }

    public function allExams(Request $req)
    {
        $exams = Exam::all();
        return view('staff.exam.all-exams', ['exams' => $exams]);
    }

    public function newExam(Request $req)
    {
        $subjects = Subject::all();
        return view('staff.exam.add-exam', ['subjects' => $subjects]);
    }

    public function addExam(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'time'=> 'required|date_format:H:i',
            'duration' => 'required|integer',
            'total_marks' => 'required|integer',
            'passing_marks' => 'required|integer',
            'subject_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $exam = new Exam();
            $exam->name = $req->title;
            $exam->date = $req->date;
            $exam->time = $req->time;
            $exam->duration = $req->duration;
            $exam->total_marks = $req->total_marks;
            $exam->passing_marks = $req->passing_marks;
            $exam->subject_id = $req->subject_id;
            $exam->save();

            return redirect()->route('staff.exams.all')
                ->with('success', 'Exam added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())
                ->with('error', 'Failed to add exam: ' . $e->getMessage());
        }
    }

    public function editExam(Request $req, $id)
    {
        $exam = Exam::find($id);
        $subjects = Subject::all();
        $questions = Question::where('subject_id', $exam->subject_id)->get();
        return view('staff.exam.edit-exam', ['exam' => $exam, 'subjects' => $subjects, 'questions' => $questions]);
    }

    public function getExamQuestions($examId)
    {
        $examSheets = ExamSheet::where('exam_id', $examId)->get();
        $questions = [];

        foreach ($examSheets as $examSheet) {
            $question = Question::find($examSheet->question_id);
            if ($question) {
                $questions[] = $question;
            }
        }

        return response()->json($questions);
    }

    public function removeQuestion(Request $req, $examId, $questionId)
    {
        $examSheet = ExamSheet::where('exam_id', $examId)
            ->where('question_id', $questionId)
            ->first();

        if ($examSheet) {
            $examSheet->delete();
            return redirect()->back()
                ->with('success', 'Question removed from exam successfully!');
        }

        return redirect()->back()
            ->with('error', 'Failed to remove question from exam!');
    }

    public function addQuestionToExam(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'exam_id' => 'required|integer',
            'question_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $examSheet = new ExamSheet();
            $examSheet->exam_id = $req->exam_id;
            $examSheet->question_id = $req->question_id;
            $examSheet->save();

            return redirect()->back()
                ->with('success', 'Question added to exam successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())
                ->with('error', 'Failed to add question to exam: ' . $e->getMessage());
        }
    }

    public function updateExam(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'time'=> 'required|date_format:H:i',
            'duration' => 'required|integer',
            'total_marks' => 'required|integer',
            'passing_marks' => 'required|integer',
            'subject_id' => 'required|integer',

        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $exam = Exam::find($id);
            $exam->name = $req->name;
            $exam->date = $req->date;
            $exam->time = $req->time;
            $exam->duration = $req->duration;
            $exam->total_marks = $req->total_marks;
            $exam->passing_marks = $req->passing_marks;
            $exam->subject_id = $req->subject_id;

            $exam->save();

            return redirect()->route('staff.exams.all')
                ->with('success', 'Exam updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage())
                ->with('error', 'Failed to update exam: ' . $e->getMessage());
        }
    }
}

