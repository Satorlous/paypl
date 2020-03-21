<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';

    protected $fillable = [
        'user_id', 'status_id', 'content'
    ];

    public static $validate = [
        'user_id'     => ['required', 'exists:App\User,id'],
        'status_id'   => ['required', 'exists:App\Status,id'],
        'content'     => ['required', 'string'],
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
