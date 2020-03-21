<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    protected $table = 'goods';

    protected $fillable = [
        'name', 'price', 'discount', 'user_id',
        'status_id', 'description', 'category_id'
    ];

    public static $validate = [
        'name'          => ['required', 'string'],
        'price'         => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
        'discount'      => ['regex:/^\d+(\.\d{1,2})?$/'],
        'user_id'       => ['required', 'exists:App\User,id'],
        'status_id'     => ['required', 'exists:App\Status,id'],
        'description'   => ['string'],
        'category_id'   => ['required', 'exists:App\Category,id'],
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function status()
    {
        return $this->belongsTo('App\Status', 'status_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'id');
    }

    /**
     * @example $this->orders->first()->pivot->quantity
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'good_order',
            'good_id', 'id')->withPivot([
                'quantity', 'price_current', 'tax_current'
        ]);
    }

}
