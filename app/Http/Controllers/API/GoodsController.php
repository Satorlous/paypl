<?php

namespace App\Http\Controllers\API;

use App\Good;
use App\Http\Controllers\Controller;
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
        //ToDo: переписать получение товаров в зависимости от идентификатора (это пока не важно)

        /*ToDo: возвращается много ненужных данных
            что точно не нужно - это id и внешние ключи
            точно нужно - name, slug, price, discount, category_slug,
            media_link - здесь только одна ссылка, и надо сделать проверку - если нет media у товара, чтобы мы отдавали какую-то картинку

            ToDo как вариант можно просто в модели сделать массив, в котором перечислить какие поля можно возвращять,
                но какой бы способ не выбрать, возникает пробелема с get
        */

        switch ($aRequest['mode']) {
            case 'popular':
                return Good::all()->forPage($aRequest['page'], $aRequest['count'])
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
                return Good::all()->forPage($aRequest['page'], $aRequest['count'])
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
                return Good::all()->forPage($aRequest['page'], $aRequest['count'])
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
                return Good::all()->forPage($aRequest['page'], $aRequest['count'])
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
        //ToDo: тут тоже с полями. список тот же + media все, еще добавляется продавец от него нужен только login
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
            ->where('slug', '=', $aRequest['slug'])
            ->each(
                function ($good) {
                    $good->media;
                    $good['is_deleted'] = !empty($good->deleted_at);
                })->first();
    }
}
