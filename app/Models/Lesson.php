<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable =[
        'title',
        'description',
        'subject_id',
        "image",
        "video",
        "file"

    ];
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
