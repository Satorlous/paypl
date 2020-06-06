<?php

namespace App\Http\Controllers\API;

use App\Good;
use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use function foo\func;

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

        switch ($aRequest['mode']) {
            case 'popular':
                return Good::all()->skip(0)->forPage($aRequest['page'], $aRequest['count'])
                    ->values()->each(
                        function ($good) {
                            if (count($good->media) > 0) {
                                $good->media_link = $good->media->first()->link;
                            } else {
                                $good->media_link = '';
                            }
                            $good['category_slug'] = $good->category->slug;
                        });
                break;
            case 'novelty':
                return Good::all()->skip(6)->forPage($aRequest['page'], $aRequest['count'])
                    ->values()->each(
                        function ($good) {
                            if (count($good->media) > 0) {
                                $good->media_link = $good->media->first()->link;
                            } else {
                                $good->media_link = '';
                            }
                            $good['category_slug'] = $good->category->slug;
                        });
                break;
            case 'sale':
                return Good::all()->skip(12)->forPage($aRequest['page'], $aRequest['count'])
                    ->values()->each(
                        function ($good) {
                            if (count($good->media) > 0) {
                                $good->media_link = $good->media->first()->link;
                            } else {
                                $good->media_link = '';
                            }
                            $good['category_slug'] = $good->category->slug;
                        });
                break;
            case 'all':
                return Good::all()->shuffle()->forPage($aRequest['page'], $aRequest['count'])
                    ->values()->each(
                        function ($good) {
                            if (count($good->media) > 0) {
                                $good->media_link = $good->media->first()->link;
                            } else {
                                $good->media_link = '';
                            }
                            $good['category_slug'] = $good->category->slug;
                        });
                break;
            default:
                return [];
        }
    }

    /**
     * Return detail about good
     *
     * @param Request $request
     *
     */
    public function good(Request $request)
    {
        $aRequest = $request->json()->all();
        $user = \auth('api')->user();
        $slug = $aRequest['slug'];
        return Good::withTrashed()->get(
            [
                'category_id',
                'description',
                'discount',
                'id',
                'name',
                'price',
                'quantity',
                'slug',
                'user_id',
                'deleted_at'
            ])
            ->where('slug', '=', $slug)
            ->each(
                function ($good) use ($user, $slug) {
                    $good->media;
                    $good['is_deleted'] = !empty($good->deleted_at);
                    if ($user) {
                        $count = Order::with('goods')->whereHas('goods',
                            function ($good) use ($slug) {
                                $good->where('slug', '=', $slug);
                            })->where([
                            'user_id' => $user->id,
                            'status_id' => Order::STATUS_DRAFT
                        ])->count();
                        $good['in_order'] = $count > 0;
                    }
                    else
                        $good['in_order'] = false;
                })->first();
    }
}
