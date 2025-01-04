<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSheet extends Model
{
    protected $fillable = [
        'exam_id',
        'question_id',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
