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
        'chapter',
        'user_id',
        'is_school_approved',
        'is_victory_approved',
        'approved_at',
        'approved_by'
    ];

    protected $casts = [
        'is_school_approved' => 'boolean',
        'is_victory_approved' => 'boolean',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function correctAnswer()
    {
        switch ($this->answer) {
            case 'a':
                return $this->option1;
            case 'b':
                return $this->option2;
            case 'c':
                return $this->option3;
            case 'd':
                return $this->option4;
            
                
            
            
        }

        return $options[$this->answer - 1];
    }

    public function checkAnswer($studentAnswer)
    {
       return $this->correctAnswer() == $studentAnswer;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function examSheets()
    {
        return $this->hasMany(ExamSheet::class);
    }

    public function studentAnswer()
    {
        return $this->hasMany(StudentAnswers::class);
    }
}
