<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\PayService
 *
 * @property int $id
 * @property string $name
 * @property string $link
 * @property string $icon
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PayService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PayService newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\PayService onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PayService query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PayService whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PayService whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PayService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PayService whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\PayService whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PayService withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\PayService withoutTrashed()
 * @mixin \Eloquent
 */
class PayService extends Model
{
    use SoftDeletes;

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
