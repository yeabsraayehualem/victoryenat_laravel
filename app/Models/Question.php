<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question',
        'option1',
        'option2',
        'option3',
        'option4',
        'answer',
        'subject_id',
        'user_id',
        'is_school_approved',
        'is_victory_approved',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function examSheets()
    {
        return $this->hasMany(ExamSheet::class);
    }

    public function studentAnswer(){
        return $this->hasMany(StudentAnswers::class);
    }
}
