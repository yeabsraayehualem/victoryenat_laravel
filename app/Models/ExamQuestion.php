<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    protected $table = 'questions';
    
    protected $fillable = [
        'exam_id',
        'question',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_answer',
        'marks'
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function studentAnswers()
    {
        return $this->hasMany(StudentAnswer::class, 'question', 'id');
    }
}
