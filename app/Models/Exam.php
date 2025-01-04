<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'name',
        'subject_id',
        'date',
        'time',
        'duration',
        'total_marks',
        'passing_marks',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function examSheets()
    {
        return $this->hasMany(ExamSheet::class);
    }
}
