<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    protected $fillable = [
        'exam_id',
        'student_id',
        'question',
        'answer',
        'correct'
    ];

    protected $casts = [
        'correct' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function question()
    {
        return $this->belongsTo(ExamQuestion::class, 'question');
    }
}
