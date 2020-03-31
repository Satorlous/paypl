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
        'good_id'         => ['required', 'exists:App\Good,id'],
        'link'            => ['required', 'string'],
        'description'     => ['string'],
        'media_type_id'   => ['required', 'exists:App\MediaType,id'],
    ];

    public $timestamps = false;

    public function type()
    {
        return $this->belongsTo(MediaType::class,'media_type_id', 'id');
    }

    public function good()
    {
        return $this->belongsTo(Good::class);
    }
}
