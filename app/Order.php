<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use function Clue\StreamFilter\fun;

/**
 * App\Order
 *
 * @property int $id
 * @property int $user_id
 * @property int $status_id
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Good[] $goods
 * @property-read int|null $goods_count
 * @property-read \App\Status $status
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Order onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Order whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Order withoutTrashed()
 * @mixin \Eloquent
 */
class Order extends Model
{
    use SoftDeletes;

    const STATUS_DRAFT = '10';
    const STATUS_CANCELLED = '11';
    const STATUS_PAID = '12';
    const STATUS_FINISHED = '13';
    protected $table = 'orders';

    protected $fillable = [
        'user_id', 'status_id', 'token'
    ];

    public static $validate = [
        'user_id'     => ['required', 'exists:App\User,id'],
        'status_id'   => ['required', 'exists:App\Status,id'],
        'token'       => ['required', 'string'],
    ];

    public function get_payment_login()
    {
        return \Config::get('constants.payment.login');
    }

    public function get_payment_pass()
    {
        return \Config::get('constants.payment.pass');
    }

    public function get_checksum($price)
    {
        $pay_login = self::get_payment_login();
        $pay_pass = self::get_payment_pass();
        return md5("$pay_login:$price:$this->id:$pay_pass");
    }

    /**
     * Сверяет контрольную сумму заказа и возвращает id заказа
     *
     * @param $price
     * @param $key
     *
     * @return int
     */
    public static function check_checksum($price, $key)
    {
        //ToDo не стал замарачиваться с этим
        return 3;
    }

    public function get_payment_url($price)
    {
        $pay_login = self::get_payment_login();
        $sv = self::get_checksum($price);
        $desc = "Заказ №$this->id";
        return "https://auth.robokassa.ru/Merchant/Index.aspx?".
            "MerchantLogin=$pay_login&OutSum=$price&InvoiceID=$this->id".
            "&Description=$desc&SignatureValue=$sv&IsTest=1";
    }


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
