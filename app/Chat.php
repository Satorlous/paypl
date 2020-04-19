<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chats';

    protected $fillable = [
        'name'
    ];

    public static $validate = [
        'name' => ['string'],
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'parties',
            'chat_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
