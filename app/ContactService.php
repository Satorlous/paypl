<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactService extends Model
{
    protected $table = 'contact_services';

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
        return $this->belongsToMany(User::class, 'contact_service_user',
            'contact_service_id')->withPivot([
                'link'
        ]);
    }
}
