<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Status
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property bool $locked
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Good[] $goods
 * @property-read int|null $goods_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Request[] $requests
 * @property-read int|null $requests_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status whereLocked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Status whereType($value)
 * @mixin \Eloquent
 */
class Status extends Model
{
    const TYPE_ORDER    = 'order';
    const TYPE_GOOD     = 'good';
    const TYPE_REQUEST  = 'request';

    protected $table = 'statuses';

    protected $fillable = [
        'name', 'type', 'locked'
    ];

    public static $validate = [
        'name'     => ['required', 'string'],
        'type'     => ['required', 'string'],
        'locked'   => ['boolean']
    ];

    public $timestamps = false;

    public function goods()
    {
        return $this->hasMany('App\Good', 'status_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order', 'status_id');
    }

    public function requests()
    {
        return $this->hasMany('App\Request', 'status_id');
    }
}
