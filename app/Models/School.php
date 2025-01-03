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
    'status'];

    public function school(){
        return $this->hasMany(User::class);
    }
}
