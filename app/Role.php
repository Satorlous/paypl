<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    const ROLE_ADMIN  = 1;
    const ROLE_SELLER = 2;
    const ROLE_BUYER  = 3;


    protected $table = 'roles';

    protected $fillable = [
        'name'
    ];

    public static $validate = [
        'name'  => ['required', 'string']
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

}
