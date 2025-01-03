<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\School;
use App\Models\User;
use App\Models\Lesson;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Subject;
class StaffController extends Controller
{
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
}
