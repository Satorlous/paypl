<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ContactService
 *
 * @property int $id
 * @property string $name
 * @property string $link
 * @property string $icon
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactService query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactService whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactService whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ContactService whereName($value)
 * @mixin \Eloquent
 */
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
