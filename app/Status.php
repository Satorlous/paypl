<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    const TYPE_ORDER    = 'order';
    const TYPE_GOOD     = 'good';
    const TYPE_REQUEST  = 'request';

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
        return $this->hasMany('App\Good', 'status_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order', 'status_id');
    }

    public function requests()
    {
        return $this->hasMany('App\Request', 'status_id');
    }
}
