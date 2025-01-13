<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\Lesson;

class Subject extends Model
{
    protected $fillable = ['name', 'description', 'shore_code',  'image', 'grade'];


    public function subject()
    {
        return $this->hasMany(Lesson::class);
    }
  public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    public function students_count(){
        $grade = $this->grade;
        $studs = User::where('grade', $grade)->where('status', 'active')->get();
        return $studs->count();
    }
    
}
