<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'good_order',
            'good_id', 'id')->withPivot([
                'quantity', 'price_current', 'tax_current'
        ]);
    }

}
