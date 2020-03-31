<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';

    protected $fillable = [
        'name', 'type', 'locked'
    ];

    public static $validate = [
        'name'     => ['required', 'string'],
        'type'     => ['required', 'string'],
        'locked'   => ['boolean']
    ];

    public $timestamps = false;

    public function goods()
    {
        return $this->hasMany('App\Good', 'id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order', 'id');
    }

    public function requests()
    {
        return $this->hasMany('App\Request', 'id');
    }
}
