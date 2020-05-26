<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

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

    public function goods()
    {
        return $this->belongsToMany(Good::class, 'good_order',
            'order_id')->withPivot([
            'quantity', 'price_current', 'tax_current'
        ]);
    }
}
