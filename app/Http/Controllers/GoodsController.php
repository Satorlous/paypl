<?php

namespace App\Http\Controllers;

use App\Good;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Контроллер для управления товарами
 *
 * Class GoodsController
 *
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
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ordersUser($id = 0)
    {
        return view('info');
    }

    /**
     * Товар детально
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function goodsDetail(Request $request)
    {
        return view('info');
    }

    /**
     * Список товаров в зависимости от параметра
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|array
     */
    public function goodsList(Request $request)
    {
        $aRequest = $request->json()->all();
        //ToDo: переписать получение товаров в зависимости от идентификатора
        switch ($aRequest['mode']) {
            case 'popular':
                return [
                    'goods' => Good::all()->forPage($aRequest['page'], $aRequest['count'])
                        ->values()->each(
                            function ($good) {
                                if (count($good->media) > 0) {
                                    $good->media_link = $good->media->first()->link;
                                } else {
                                    $good->media_link = '';
                                }
                            }),
                ];
                break;
            case 'novelty':
                return [
                    'goods' => Good::all()->forPage($aRequest['page'], $aRequest['count'])
                        ->values()->each(
                            function ($good) {
                                if (count($good->media) > 0) {
                                    $good->media_link = $good->media->first()->link;
                                } else {
                                    $good->media_link = '';
                                }
                            }),
                ];
                break;
            case 'all':
                return [
                    'goods' => Good::all()->forPage($aRequest['page'], $aRequest['count'])
                        ->values()->each(
                            function ($good) {
                                if (count($good->media) > 0) {
                                    $good->media_link = $good->media->first()->link;
                                } else {
                                    $good->media_link = '';
                                }
                            }),
                ];
                break;
            default:
                return [];
        }
    }
}
