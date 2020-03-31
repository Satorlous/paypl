<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaType extends Model
{
    protected $table = 'media_types';

    protected $fillable = [
        'name'
    ];

    public static $validate = [
        'name' => ['required', 'string'],
    ];

    public $timestamps = false;

    public function medias()
    {
        return $this->hasMany(Media::class);
    }
}
