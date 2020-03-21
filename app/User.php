<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'login',
        //ToDo: расскомментировать как доделаем модели
        /*
        'avatar', 'role_id'
        */
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $validate = [
        'name'       => ['required', 'string', 'max:255'],
        'email'      => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password'   => ['required', 'string', 'min:8', 'confirmed'],
        'login'      => ['required', 'string', 'max:255'],
    ];

    /**
     * @example $this->contactServices->first()->pivot->link
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function contactServices()
    {
        return $this->belongsToMany(ContactService::class, 'contact_service_user',
            'user_id','id')->withPivot(['link']);
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function requests()
    {
        return $this->hasMany(Request::class, 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'id');
    }

    public function goods()
    {
        return $this->hasMany(Goods::class, 'id');
    }

}
