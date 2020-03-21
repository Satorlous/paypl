<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'good_id', 'link', 'description', 'media_type_id',
    ];

    public static $validate = [
        'good_id'         => ['required', 'exists:App\Goods,id'],
        'link'            => ['required', 'string'],
        'media_type_id'   => ['required', 'exists:App\MediaType,id'],
    ];

    public function type()
    {
        return $this->belongsTo(MediaType::class,'media_type_id', 'id');
    }
}
