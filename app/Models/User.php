<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'school',
        'grade',
        'role',
        'is_active',
        'email',
        'password',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function users(){
        return $this->belongsTo(School::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function school(){
        return $this->belongsTo(School::class);
    }

    public function teachers(){
        return $this->hasMany(Teacher::class);
    }

    public function studentAnswer(){
        return $this->hasMany(StudentAnswers::class);
    }

    public function chatGroups()
    {
        return $this->belongsToMany(ChatGroup::class, 'chat_group_members')
            ->withTimestamps();
    }

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class);
    }
}
