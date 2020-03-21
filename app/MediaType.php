<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaType extends Model
{
    protected $table = 'media_types';

    protected $fillable = [
        'good_id', 'link', 'description', 'type'
    ];

    public static $validate = [
        'link'          => ['required', 'string'],
        'description'   => ['string'],
        'type'          => ['required', 'integer'],
    ];

    public function medias()
    {
        return $this->hasMany(Media::class, 'id');
    }
}
