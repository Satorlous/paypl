<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'login', 'avatar', 'balance', 'role_id', 'rating'
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
        'login'      => ['required', 'string', 'max:255', 'unique:users'],
    ];

    /**im
     * @example $this->contactServices->first()->pivot->link
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function contactServices()
    {
        return $this->belongsToMany(ContactService::class, 'contact_service_user',
            'user_id')->withPivot(['link']);
    }

    public function payServices()
    {
        return $this->belongsToMany(PayService::class, 'pay_service_user',
            'user_id')->withPivot(['link']);
    }

    public function chats()
    {
        return $this->belongsToMany(Chat::class, 'parties',
            'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function requests()
    {
        return $this->hasMany(Request::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function goods()
    {
        return $this->hasMany(Good::class, 'user_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'user_id');
    }

    public static function getUniqueToken()
    {
        $value = 100000000;
        $value -= self::all()->last()->id + 1;
        return "id$value";
    }

    /**
     * Проверка пользователя на продавца
     *
     * @return bool
     */
    public function isSeller() {
        return $this->role->id == Role::ROLE_SELLER;
    }

    public function getDataForFrontend()
    {
        return [
            'name'   => $this->name,
            'avatar' => $this->avatar,
            'seller' => $this->isSeller(),
        ];
    }
}
