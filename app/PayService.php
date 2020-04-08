<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PayService extends Model
{
    protected $table = 'pay_services';

    protected $fillable = [
        'name', 'link', 'icon'
    ];

    public static $validate = [
        'name'   => ['required', 'string'],
        'link'   => ['required', 'string'],
        'icon'   => ['required', 'string']
    ];

    public $timestamps = false;

    /**
     * @example $this->users->first()->pivot->link
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'pay_service_user',
            'pay_service_id')->withPivot([
            'link'
        ]);
    }
}
