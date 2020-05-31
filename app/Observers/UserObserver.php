<?php

namespace App\Observers;

use App\User;
use Illuminate\Support\Facades\Hash;

class UserObserver
{
    /**
     * Handle the user "updated" event.
     *
     * @param \App\Good $model
     * @return void
     */
    public function updating(User $model)
    {
        /**
         * Хэширование пароля пользователя
         */
        if ($model->getOriginal('password') != $model->getAttribute('password')) {
            $model->password = Hash::make($model->password);
        }
    }
}
