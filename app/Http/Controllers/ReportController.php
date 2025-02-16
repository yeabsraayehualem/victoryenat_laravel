<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use App\Models\Exam;
use App\Models\ExamSheet;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Get all schools with basic info
        $schools = School::all();
        
        // Get schools by city
        $schoolsByCity = School::select('city', DB::raw('count(*) as total'))
            ->groupBy('city')
            ->orderBy('city')
            ->get();

        return view('staff.reports.index', compact('schools', 'schoolsByCity'));
    }

    public function schoolDetail($schoolId)
    {
        $school = School::query()
            ->with([
                'students' => fn($query) => $query->select(
                    'id', 'school_id', 'first_name', 'last_name', 
                    'grade', 'profile_photo'
                )->orderBy('first_name'),
                
                'teachers' => fn($query) => $query->select(
                    'id', 'school_id', 'first_name', 'last_name',
                    'subject', 'phone', 'profile_photo', 'is_active'
                )->orderBy('first_name'),
                
                'managers' => fn($query) => $query->select(
                    'id', 'school_id', 'first_name', 'last_name',
                    'role', 'phone', 'profile_photo', 'is_active'
                )->orderBy('role')
            ])
            ->findOrFail($schoolId);

        return view('staff.reports.school-detail', compact('school'));
    }

    public function getStudents(Request $request, $schoolId)
    {
        $query = User::where('role', 'student')
            ->where('school_id', $schoolId);
        
        // Search filter
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function($q) use ($search) {
                $q->whereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                  ->orWhere('student_id', 'LIKE', "%{$search}%");
            });
        }

        // Grade filter
        if ($request->filled('grade')) {
            $query->where('grade', $request->grade);
        }

        // Sorting
        switch ($request->input('sort', 'name_asc')) {
            case 'name_desc':
                $query->orderByRaw("CONCAT(first_name, ' ', last_name) DESC");
                break;
            case 'grade_high':
                $query->orderByDesc('grade');
                break;
            case 'grade_low':
                $query->orderBy('grade');
                break;
            default: // name_asc
                $query->orderByRaw("CONCAT(first_name, ' ', last_name) ASC");
        }

        $students = $query->get();

        return view('staff.reports.partials.students-table', compact('students'));
    }
}
