<?php

namespace App\Observers;

use App\Good;
use App\Order;
use Illuminate\Support\Str;

class GoodObserver
{
    /**
     * Handle the good "created" event.
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
                    $order->update(['token' => $order->get_checksum($model->price)]);
                    $order->goods()->updateExistingPivot($model->id,
                        [
                            'price_current' => $model->price,
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
