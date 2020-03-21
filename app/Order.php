<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'user_id', 'status_id', 'token'
    ];

    public static $validate = [
        'user_id'     => ['required', 'exists:App\User,id'],
        'status_id'   => ['required', 'exists:App\Status,id'],
        'token'       => ['required', 'string'],
    ];

    public function user()
    {
        return $this->belongsTo( User::class, 'user_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    /**
     * @example $this->goods->first()->pivot->quantity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function goods()
    {
        return $this->belongsToMany(Goods::class, 'good_order',
            'order_id', 'id')->withPivot([
            'quantity', 'price_current', 'tax_current'
        ]);
    }
}
