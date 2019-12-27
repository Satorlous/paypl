<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Контроллер для управления сервисами оплаты и связи(соц сети, почта, хз что еще будет)
 * Class ServicesController
 * @package App\Http\Controllers
 */
class ServicesController extends Controller
{
    /**
     * Список контактных сервисов пользователя
     *
     * @param int $id Идентификатор пользователя
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contactServices($id = 0)
    {
        return view('info');
    }

    /**
     * Список платежных сервисов пользователя
     *
     * @param int $id Идентификатор пользователя
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function payServices($id = 0)
    {
        return view('info');
    }

    /**
     * Все что дальше возможно уйдет по другим контороллерам
     */

    /**
     * Список статусов это только для админов
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function statuses()
    {
        return view('info');
    }

    /**
     * Список ролей пользователей
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function roles()
    {
        return view('info');
    }

    /**
     * Страница с категорией
     *
     * @param int $id Id категории
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category($id = 0)
    {
        return view('info');
    }

    /**
     * Страница с подкатегорией
     *
     * @param int $id Id подкатегории
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function subcategory($id = 0)
    {
        return view('info');
    }
}
