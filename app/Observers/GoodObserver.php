<?php

namespace App\Observers;

use App\Good;
use Illuminate\Support\Str;

class GoodObserver
{
    /**
     * Handle the good "created" event.
     *
     * @param  \App\Good  $good
     * @return void
     */
    public function creating(Good $good)
    {
        $i = Good::max('id')+1;
        $good->slug = 'product'.$i;
    }

    /**
     * Handle the good "updated" event.
     *
     * @param  \App\Good  $good
     * @return void
     */
    public function updating(Good $good)
    {

    }

    /**
     * Handle the good "deleted" event.
     *
     * @param  \App\Good  $good
     * @return void
     */
    public function deleted(Good $good)
    {
        //
    }

    /**
     * Handle the good "restored" event.
     *
     * @param  \App\Good  $good
     * @return void
     */
    public function restored(Good $good)
    {
        //
    }

    /**
     * Handle the good "force deleted" event.
     *
     * @param  \App\Good  $good
     * @return void
     */
    public function forceDeleted(Good $good)
    {
        //
    }
}
