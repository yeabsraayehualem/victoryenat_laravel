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

    protected $casts = [
        'is_school_approved' => 'boolean',
        'is_victory_approved' => 'boolean',
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

    public function correctAnswer()
    {
        $answerMap = [
            'a' => $this->option1,
            'b' => $this->option2,
            'c' => $this->option3,
            'd' => $this->option4,
        ];

        $key = strtolower($this->answer);
        return $answerMap[$key] ?? null;
    }

    public function studentAnswer()
    {
        return $this->hasMany(StudentAnswers::class);
    }
}
