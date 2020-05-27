<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Media
 *
 * @property int $id
 * @property int $good_id
 * @property string $link
 * @property int $media_type_id
 * @property string|null $description
 * @property-read \App\Good $good
 * @property-read \App\MediaType $type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereGoodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Media whereMediaTypeId($value)
 * @mixin \Eloquent
 */
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
