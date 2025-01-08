<?php

namespace App\Models;
use App\Models\User;
use App\Models\Exam;
use Illuminate\Database\Eloquent\Model;

class StudentResult extends Model
{
    protected $fillable = [
        'student_id',
        'exam_id',
        'result',
        'pass_fail'
    ];



    public function student(){
        return $this->belongsTo(User::class);
    }

    public function exam(){
        return $this->belongsTo(Exam::class);
    }
}
