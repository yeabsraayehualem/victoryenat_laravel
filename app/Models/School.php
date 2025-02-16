<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = ['name',
    'address',
     'phone',
      'email',
      'website',
       'logo',
       'school_type',
    'status'];

    public function school(){
        return $this->hasMany(User::class);
    }

    public function students(){
        return User::where('role', 'student')->where('school_id', $this->id)->get();
    }
    public function teachers(){
        return User::where('role', 'teacher')->where('school_id', $this->id)->get();
    }
}
