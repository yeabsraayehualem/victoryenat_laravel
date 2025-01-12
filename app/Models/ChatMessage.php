<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'chat_group_id',
        'user_id',
        'content',
        'type', // 'text', 'image', 'file'
        'file_path',
        'file_name',
        'file_size'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function group()
    {
        return $this->belongsTo(ChatGroup::class, 'chat_group_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
