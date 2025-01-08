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

    public function studentAnswer(){
        return $this->hasMany(StudentAnswers::class);
    }

    public function isOngoing()
    {
        return now()->isSameDay($this->date) &&
               now()->gte($this->time) &&
               now()->lte($this->time->copy()->addMinutes($this->duration));
    }

   

}
