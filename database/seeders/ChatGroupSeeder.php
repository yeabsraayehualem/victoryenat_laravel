<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\ChatGroup;
use App\Models\User;
use Illuminate\Database\Seeder;

class ChatGroupSeeder extends Seeder
{
    public function run()
    {
        $schools = School::all();
        
        foreach ($schools as $school) {
            // Create staff group
            $staffGroup = ChatGroup::create([
                'name' => "{$school->name} Staff",
                'type' => 'staff',
                'school_id' => $school->id
            ]);
            
            // Create manager-staff group
            $managerStaffGroup = ChatGroup::create([
                'name' => "{$school->name} Managers & Staff",
                'type' => 'manager_staff',
                'school_id' => $school->id
            ]);
            
            // Create teachers group
            $teachersGroup = ChatGroup::create([
                'name' => "{$school->name} Teachers",
                'type' => 'teacher_school',
                'school_id' => $school->id
            ]);
            
            // Get all grades in the school
            $grades = User::where('school_id', $school->id)
                        ->where('role', 'student')
                        ->distinct()
                        ->pluck('grade');
            
            // Create student groups for each grade
            foreach ($grades as $grade) {
                ChatGroup::create([
                    'name' => "{$school->name} Grade {$grade} Students",
                    'type' => 'student_grade',
                    'school_id' => $school->id,
                    'grade' => $grade
                ]);
            }
            
            // Add members to their respective groups
            $users = User::where('school_id', $school->id)->get();
            
            foreach ($users as $user) {
                switch ($user->role) {
                    case 'student':
                        $gradeGroup = ChatGroup::where('school_id', $school->id)
                            ->where('type', 'student_grade')
                            ->where('grade', $user->grade)
                            ->first();
                        if ($gradeGroup) {
                            $gradeGroup->members()->attach($user->id);
                        }
                        break;
                        
                    case 'teacher':
                        $teachersGroup->members()->attach($user->id);
                        break;
                        
                    case 'staff':
                        $staffGroup->members()->attach($user->id);
                        $managerStaffGroup->members()->attach($user->id);
                        break;
                        
                    case 'manager':
                        $managerStaffGroup->members()->attach($user->id);
                        break;
                }
            }
        }
    }
}
