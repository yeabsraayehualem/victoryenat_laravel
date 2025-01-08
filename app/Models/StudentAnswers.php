<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Exam;
use App\Models\User;
use App\Models\Question;
class StudentAnswers extends Model
{
    protected $fillable =[
        'student_id',
        'exam_id',
        'question_id',
        'answer',
        'correct'
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }
    public function exam(){
        return $this->belongsTo(Exam::class);

    }
    public function question(){
        return $this->belongsTo(Question::class);
    }
}
