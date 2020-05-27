<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MediaType
 *
 * @property int $id
 * @property string $name
 * @property string $extensions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Media[] $medias
 * @property-read int|null $medias_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MediaType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MediaType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MediaType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MediaType whereExtensions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MediaType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\MediaType whereName($value)
 * @mixin \Eloquent
 */
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
