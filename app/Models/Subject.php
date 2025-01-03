<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'description', 'image', 'shore_code', 'grade'];


    public function subject()
    {
        return $this->hasMany(Lesson::class);

    }
}
