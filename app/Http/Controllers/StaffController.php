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
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function getUserData()
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
        $schools = School::paginate(10);
        return view('staff.school.all-schools', ['schools' => $schools]);
    }

    public function activeSchools(Request $req)
    {
        $schools = School::where('status', 'active')->paginate(10);
        return view('staff.school.all-schools', ['schools' => $schools]);
    }

    public function addSchool(Request $req)
    {
        try {
            $validated = $req->validate([
                'name' => 'required',
                'phone' => 'required',
                'email' => 'required|email',
                'address' => 'required',
                'website' => 'string|nullable|url',
                'school_type' => 'required',
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ], [
                'name.required' => 'School name is required',
                'phone.required' => 'Phone number is required',
                'email.required' => 'Email address is required',
                'email.email' => 'Please enter a valid email address',
                'address.required' => 'School address is required',
                'school_type.required' => 'School type is required',
                'website.url' => 'Please enter a valid website URL',
                'logo.required' => 'School logo is required',
                'logo.image' => 'The file must be an image',
                'logo.mimes' => 'The logo must be a file of type: jpeg, png, jpg, gif, svg',
                'logo.max' => 'The logo must not be larger than 2MB'
            ]);

            $school = new School();
            $school->name = $req->name;
            $school->website = $req->website;
            $school->email = $req->email;
            $school->address = $req->address;
            $school->phone = $req->phone;
            $school->school_type = $req->school_type;
            
            if ($req->hasFile('logo')) {
                try {
                    $file = $req->file('logo');
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('uploads/schools', $fileName, 'public');
                    $school->logo = $filePath;
                } catch (\Exception $e) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Failed to upload logo: ' . $e->getMessage());
                }
            }

            $school->save();
            return redirect()->route('staff.schools')->with('success', 'School added successfully!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput()
                ->with('error', 'Please correct the errors below');
        } catch (\Exception $e) {
            \Log::error('School creation error: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to add school: ' . $e->getMessage());
        }
    }

    public function deactivateSchool(Request $req, $id)
    {
        $school = School::find($id);
        $school->status = 'inactive';
        $school->save();
        return redirect()->route('staff.schools');
    }
    public function activateSchool(Request $req, $id)
    {
        $school = School::find($id);
        $school->status = 'active';
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
        try {
            $school = School::findOrFail($id);
            
            // Get school managers
            $schoolManagers = User::where('role', 'school_manager')
                                ->where('school_id', $school->id)
                                ->get();

            // Get teachers
            $teachers = User::where('role', 'teacher')
                          ->where('school_id', $school->id)
                          ->get();

            // Initialize students query
            $studentsQuery = User::where('role', 'student')
                               ->where('school_id', $school->id);

            // Apply search filter
            if ($req->filled('search')) {
                $search = $req->search;
                $studentsQuery->where(function($query) use ($search) {
                    $query->where('first_name', 'LIKE', "%{$search}%")
                          ->orWhere('last_name', 'LIKE', "%{$search}%")
                          ->orWhere('student_id', 'LIKE', "%{$search}%");
                });
            }

            // Apply grade filter
            if ($req->filled('grade')) {
                $studentsQuery->where('grade', $req->grade);
            }

            // Apply sorting
            if ($req->filled('sort')) {
                switch ($req->sort) {
                    case 'name_asc':
                        $studentsQuery->orderBy('first_name')->orderBy('last_name');
                        break;
                    case 'name_desc':
                        $studentsQuery->orderByDesc('first_name')->orderByDesc('last_name');
                        break;
                    case 'grade_asc':
                        $studentsQuery->orderBy('grade');
                        break;
                    case 'grade_desc':
                        $studentsQuery->orderByDesc('grade');
                        break;
                    default:
                        $studentsQuery->orderBy('first_name');
                }
            } else {
                $studentsQuery->orderBy('first_name');
            }

            $students = $studentsQuery->get();

            // Get counts for stats
            $totalTeachers = $teachers->count();
            $totalStudents = User::where('role', 'student')
                               ->where('school_id', $school->id)
                               ->count();
            $totalSubjects = Subject::count();
            
            // Calculate school performance (you can modify this based on your requirements)
            $performance = 0; // Add your performance calculation logic here

            return view('staff.school.school-detail', [
                'school' => $school,
                'schoolManagers' => $schoolManagers,
                'teachers' => $teachers,
                'students' => $students,
                'totalTeachers' => $totalTeachers,
                'totalStudents' => $totalStudents,
                'totalSubjects' => $totalSubjects,
                'performance' => $performance
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading school details: ' . $e->getMessage());
        }
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
        $subjects = Subject::paginate(10);
        $students = User::where('role', 'student')->where('status', 'active')->get();
        $teachers = User::where('role', 'teacher')->where('status', 'active')->get();
        return view('staff.lessons.subjects', compact('subjects', 'students', 'teachers'));
    }

    public function editSubject(Request $request, $id){
        $subject = Subject::find($id);

        return view('staff.lessons.add_subject', compact('subject'));
    }

    public function addSubject(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'shore_code' => 'required|string|max:50|unique:subjects,shore_code',
            'description' => 'required|string',
            'grade' => 'nullable|integer|min:1|max:12',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $subject = Subject::create($validatedData);

        return redirect()->route('staff.subjects.all')->with('success', 'Subject created successfully');
    }

    public function updateSubject(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'shore_code' => 'required|string|max:50|unique:subjects,shore_code,' . $subject->id,
            'description' => 'required|string',
            'grade' => 'nullable|integer|min:1|max:12',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $subject->update($validatedData);

        return redirect()->route('staff.subjects.all')->with('success', 'Subject updated successfully');
    }

    public function subjectDetail(Request $req, $id)
    {
      
        $subject = Subject::findOrFail($id);
        $students = User::where('role', 'student')->where('status', 'active')->where('grade', $subject->grade)->get();
        $teachers = User::where('role', 'teacher')->where('status', 'active')->get();
     
        $lessons = Lesson::where('subject_id', $subject->id)->get();
        return view('staff.lessons.subject-detail', compact('subject', 'students', 'teachers', 'lessons'));
    }

    public function createSubjectView()
    {
        return view('staff.lessons.add_subject');
    }

    public function createSubject(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'shore_code' => 'required|string|max:50|unique:subjects,shore_code',
            'description' => 'required|string',
            'exam_duration' => 'required|integer|min:1',
            'total_questions' => 'required|integer|min:1'
        ]);

        $subject = Subject::create($validatedData);

        return redirect()->route('staff.subjects.all')->with('success', 'Subject created successfully');
    }

    public function allLessons(Request $request)
    {
        $lessons = Lesson::paginate(10);
        $subjects = Subject::all();
        return view('staff.lessons.lessons', ['lessons' => $lessons,'subjects'=>$subjects]);
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
        $questions = Question::where('subject_id', $exam->subject_id)->where('is_school_approved', 1)->where('is_victory_approved', 1)->get();
        return view('staff.exam.edit-exam', ['exam' => $exam, 'subjects' => $subjects, 'questions' => $questions]);
    }

    public function getExamQuestions($examId)
    {
        $examSheets = ExamSheet::where('exam_id', $examId)->get();
        $examquestions = [];

        foreach ($examSheets as $examSheet) {
            $question = Question::find($examSheet->question_id);
            if ($question) {
                $examquestions[] = $question;
            }
        }

        return response()->json($examquestions);
    }

    public function removeQuestion(Request $req, $exam, $question)
{
    $examSheet = ExamSheet::where('exam_id', $exam)
        ->where('question_id', $question)
        ->first();

    if ($examSheet) {
        $examSheet->delete();
        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false]);
}

    public function addQuestionToExam(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'exam_id' => 'required|integer',
            'question_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()]);
        }

        try {
            $examSheet = new ExamSheet();
            $examSheet->exam_id = $req->exam_id;
            $examSheet->question_id = $req->question_id;
            $examSheet->save();

            return response()->json(['success' => true, 'message' => 'Question added to exam successfully!']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to add question to exam: ' . $e->getMessage()]);
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

    public function approveQuestion(Request $req, $id)
    {
        $question = Question::find($id);
        $question->is_victory_approved = 1;
        $question->is_school_approved = 1;
        $question->save();
        return redirect()->route('staff.questions.all')->with('success', 'Question approved successfully');
    }

    public function rejectQuestion(Request $req, $id)
    {
        $question = Question::find($id);
        $question->is_victory_approved = 0;
        $question->save();
        return redirect()->route('staff.questions.all')->with('success', 'Question rejected successfully');
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        // Validate the request data
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'school' => 'nullable|string|max:255',
            'status' => 'in:active,inactive',
            'password' => 'nullable|string|min:6|confirmed',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Update user fields
        $user->first_name = $validatedData['first_name'];
        $user->last_name = $validatedData['last_name'];
        $user->email = $validatedData['email'];
        $user->phone = $validatedData['phone'] ?? $user->phone;
        $user->school = $validatedData['school'] ?? $user->school;
        $user->status = $validatedData['status'] ?? $user->status;

        // Update password if provided
        if (!empty($validatedData['password'])) {
            $user->password = bcrypt($validatedData['password']);
        }

        // Handle profile image upload
        if ($request->hasFile('profile')) {
            // Delete old profile image if exists
            if ($user->profile) {
                Storage::delete('public/' . $user->profile);
            }

            // Store new profile image
            $profilePath = $request->file('profile')->store('profiles', 'public');
            $user->profile = $profilePath;
        }

        $user->save();

        // Redirect back with success message
        return redirect()->route('staff.profile')->with('success', 'Profile updated successfully');
    }

    public function profile()
    {
        return view('staff.profile');
    }

    public function getStudents(Request $req, $schoolId)
    {
        try {
            // Initialize students query
            $studentsQuery = User::where('role', 'student')
                               ->where('school_id', $schoolId);

            // Apply search filter
            if ($req->filled('search')) {
                $search = trim($req->search);
                $studentsQuery->where(function($query) use ($search) {
                    $query->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                          ->orWhere('student_id', 'LIKE', "%{$search}%");
                });
            }

            // Apply grade filter
            if ($req->filled('grade') && is_numeric($req->grade)) {
                $studentsQuery->where('grade', intval($req->grade));
            }

            // Apply sorting
            switch ($req->input('sort', 'name_asc')) {
                case 'name_desc':
                    $studentsQuery->orderByRaw("CONCAT(first_name, ' ', last_name) DESC");
                    break;
                case 'grade_asc':
                    $studentsQuery->orderBy('grade')->orderByRaw("CONCAT(first_name, ' ', last_name)");
                    break;
                case 'grade_desc':
                    $studentsQuery->orderByDesc('grade')->orderByRaw("CONCAT(first_name, ' ', last_name)");
                    break;
                default: // name_asc
                    $studentsQuery->orderByRaw("CONCAT(first_name, ' ', last_name) ASC");
            }

            $students = $studentsQuery->get();

            return view('staff.school.partials.students-table', compact('students'));
        } catch (\Exception $e) {
            \Log::error('Error in getStudents: ' . $e->getMessage());
            
            // Return an error response that HTMX can handle
            return response()->view('staff.school.partials.students-table', [
                'students' => collect(),
                'error' => 'An error occurred while loading students.'
            ], 500);
        }
    }
}
