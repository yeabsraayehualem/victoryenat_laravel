<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type', // 'student_grade', 'teacher_school', 'manager_staff', 'staff'
        'school_id',
        'grade' // nullable, only for student groups
    ];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'chat_group_members')
            ->withTimestamps();
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
