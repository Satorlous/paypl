<?php

namespace App\Observers;

use App\Good;
use App\Order;
use Illuminate\Support\Str;

class GoodObserver
{
    /**
     * Handle the good "creating" event.
     *
     * @param \App\Good $good
     * @return void
     */
    public function creating(Good $good)
    {
        $i = Good::max('id') + 1;
        $good->slug = 'product' . $i;
        $good->status_id = 1;
        if ($good->quantity)
            $good->is_unlimited = false;
    }


    /**
     * Handle the good "updating" event.
     *
     * @param \App\Good $good
     * @return void
     */
    public function updating(Good $good)
    {
        if (!$good->is_unlimited && $good->quantity == 0)
        {
            $good->status_id = Good::STATUS_SOLD;
        }
    }


    /**
     * Handle the good "updated" event.
     *
     * @param \App\Good $model
     * @return void
     */
    public function updated(Good $model)
    {
        /**
         * Обновление цены товаров в good_order на актуальную, заказы которых в статусе ЧЕРНОВИК
         */
        if ($model->getOriginal('price') != $model->getAttribute('price')) {
            $order = Order::where('status_id', Order::STATUS_DRAFT)
                ->whereHas('goods',
                    function ($good) use ($model) {
                        $good->where('slug', '=', $model->slug);
                    }
                )
                ->each(function (Order $order) use ($model) {
                    $price = $model->final_price();
                    $order->update(['token' => $order->get_checksum($price)]);
                    $order->goods()->updateExistingPivot($model->id,
                        [
                            'price_current' => $price,
                            'tax_current' => $model->category->tax
                        ]
                    );
                });
        }
    }

    /**
     * Handle the good "deleted" event.
     *
     * @param \App\Good $good
     * @return void
     */
    public function deleted(Good $good)
    {
        //
    }

    /**
     * Handle the good "restored" event.
     *
     * @param \App\Good $good
     * @return void
     */
    public function restored(Good $good)
    {
        //
    }

    /**
     * Handle the good "force deleted" event.
     *
     * @param \App\Good $good
     * @return void
     */
    public function forceDeleted(Good $good)
    {
        //
    }
}
