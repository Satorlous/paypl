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
    public function created(Good $good)
    {
        $good->slug = Str::slug($good->name);
        $good->save();
    }

    /**
     * Handle the good "updated" event.
     *
     * @param  \App\Good  $good
     * @return void
     */
    public function updated(Good $good)
    {
        $good->slug = Str::slug($good->name);
        $good->save();
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
