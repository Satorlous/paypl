<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Контроллер для управления товарами и заказами (вместе так как логика одинаковая, одно зависит от другого)
 *
 * Class GoodsController
 * @package App\Http\Controllers
 */
class GoodsController extends Controller
{
    /**
     * Список товаров определенного пользователя
     *
     * @param int $id Идентификатор пользователя
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function goodsUser($id = 0)
    {
        return view('info');
    }

    /**
     * Список заказов определенного пользователя
     *
     * @param int $id Идентификатор пользователя
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ordersUser($id = 0)
    {
        return view('info');
    }

    /**
     * Детальная страница товара
     *
     * @param int $id Id товара
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function goodsDetail($id =0)
    {
        return view('info');
    }
}
