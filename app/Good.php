<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * App\Good
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property float $price
 * @property int|null $quantity
 * @property float|null $discount
 * @property int $status_id
 * @property string|null $description
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property boolean $is_unlimited
 * @property-read \App\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Media[] $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Order[] $orders
 * @property-read int|null $orders_count
 * @property-read \App\Status $status
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Good newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Good newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Good onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Good query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Good whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Good whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Good whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Good whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Good whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Good whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Good whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Good wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Good whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Good whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Good whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Good whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Good whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Good withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Good withoutTrashed()
 * @mixin \Eloquent
 */
class Good extends Model
{
    use SoftDeletes;

    protected $table = 'goods';

    protected $fillable = [
        'name', 'price', 'discount', 'user_id',
        'status_id', 'description', 'category_id',
        'quantity', 'is_unlimited'
    ];

    public static $validate = [
        'name'          => ['required', 'string'],
        'price'         => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
        'discount'      => ['regex:/^\d+(\.\d{1,2})?$/'],
        'quantity'      => ['nullable', 'integer', 'min:1'],
        'description'   => ['string'],
    ];

    public static $validate_update = [
        'name'          => ['required', 'string'],
        'price'         => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
        'discount'      => ['regex:/^\d+(\.\d{1,2})?$/'],
        'user_id'       => ['required', 'exists:App\User,id'],
        'status_id'     => ['required', 'exists:App\Status,id'],
        'quantity'      => ['nullable', 'integer', 'min:1'],
        'description'   => ['string'],
        'category_id'   => ['required', 'exists:App\Category,id'],
    ];

    public function final_price()
    {
        return $this->discount > 0 ? $this->discount : $this->price;
    }

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
            'good_id')->withPivot([
                'quantity', 'price_current', 'tax_current'
        ]);
    }

}
