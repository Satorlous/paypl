<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Контроллер для управление профилем пользователя
 *
 * Class ProfileController
 *
 * @package App\Http\Controllers
 */
class ProfileController extends Controller
{
    /**
     * Профиль пользователя
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile()
    {
        return view('info');
    }

    /**
     * Ссылка на страницу общей статистики (как по покупкам, так и по продажам)
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profileStatistics()
    {
        return view('info');
    }
}
