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

    public function Goods()
    {
        return $this->hasMany('App\Goods', 'id');
    }

    public function Orders()
    {
        return $this->hasMany('App\Order', 'id');
    }

    public function Requests()
    {
        return $this->hasMany('App\Request', 'id');
    }
}
