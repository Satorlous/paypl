<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'content', 'user_id', 'chat_id', 'created_at'
    ];

    public static $validate = [
        'content' => ['required', 'string'],
        'user_id' => ['required ', 'exists:App\User,id'],
        'chat_id' => ['required ', 'exists:App\Chat,id'],
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }
}
