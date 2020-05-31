<?php

namespace App\Http\Controllers\API;

use App\Good;
use App\Http\Controllers\Controller;
use App\Order;
use App\Status;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrdersDataController extends Controller
{

    public function orderListByBuyer(Request $request)
    {
        $data = $request->json()->all();
        $user = \auth('api')->user();
        $orders = Order::where(
            [
                'user_id' => $user->id,
                'status_id' => $data['status_id'],
            ])
            ->with(['goods' => function ($good) {
                $good->with('category');
            }])
            ->get();
        $request['mode'] = $request['mode'] ?? 'new';
        switch ($request['mode']) {
            case "old":
                return $orders->sortBy('updated_at')->values();
                break;
            case "new":
                return $orders->sortByDesc('updated_at')->values();
                break;
            default:
                return [];
        }
    }

    public function orderListByGoodOwner(Request $request)
    {
        $data = $request->json()->all();
        $good_owner_id = $data['user_id'];
        $orders = Order::with('goods')->whereHas('goods',
            function ($good) use ($good_owner_id) {
                $good->where('user_id', '=', $good_owner_id);
            })->get()->toArray();

        $i = 0;
        foreach ($orders as $order) {
            $orders[$i]['goods'] = array_filter($order['goods'],
                function ($good) use ($good_owner_id) {
                    return $good['user_id'] === $good_owner_id;
                });
            $i++;
        }
        return $orders;
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();
        if (!$data['slug'])
            return self::bad_request(['slug' => 'Поле slug обязательно']);

        $user = \auth('api')->user();
        $good = Good::whereSlug($data['slug'])->first();
        $order = Order::create([
            'user_id' => $user->id,
            'status_id' => Order::STATUS_DRAFT,
            'token' => 'token'
        ]);

        $order->token = $order->get_checksum($good->final_price());
        $order->save();
        $order->goods()->attach($good->id, [
            'quantity' => 1,
            'price_current' => $good->price,
            'tax_current' => $good->category->tax
        ]);
        return self::success(Response::HTTP_OK);
    }

    public function update(Request $request)
    {
        $data = $request->json()->all();
        $status_id = $data['status_id'];
        $order = Order::find($data['id']);
        $goods = $order->goods;
        $order->status_id = $data['status_id'];

        if ($status_id == Order::STATUS_PAID)
        {
            foreach ($goods as $good)
            {
                if (!$good->is_unlimited)
                {
                    $good->quantity -= $good->pivot->quantity;
                    $good->save();
                }
                $good->user->balance += $good->pivot->price_current * $good->pivot->quantity;
                $good->user->save();
            }
        }

        if ($status_id == Order::STATUS_FINISHED)
        {
            foreach ($goods as $good)
            {
                $diff = $good->pivot->price_current * $good->pivot->quantity;
                $good->user->balance -= $diff;
                $good->user->withdraw_balance += $diff;
                $good->user->save();
            }
        }

        if ($status_id == Order::STATUS_CANCELLED)
        {
            foreach ($goods as $good)
            {
                if (!$good->is_unlimited)
                {
                    $good->quantity += $good->pivot->quantity;
                    $good->save();
                }
                $diff = $good->pivot->price_current * $good->pivot->quantity;
                $good->user->balance -= $diff;
                $good->user->withdraw_balance += $diff;
                $good->user->save();
            }
        }
    }

    public function destroy(Request $request)
    {
        $data = $request->json()->all();
        if (!$data['id'])
            return self::bad_request(['id' => 'Поле id обязательно']);
        $model = Order::find($data['id']);
        $ids = array_column($model->goods->all(), 'id');
        $model->goods()->detach($ids);
        $model->forceDelete();
        return self::success(Response::HTTP_OK);
    }

    public function payment(Request $request)
    {
        $data = $request->json()->all()['order'];
        $goods_in_order = $data['goods'];
        $final_price = 0;
        foreach ($goods_in_order as $good) {
            $model = Good::find($good['id']);
            $q = $good['pivot']['quantity'];
            $final_price += $model->price * $q;
            $model->orders()->updateExistingPivot($data['id'],
                ['quantity' => $q]);
        }
        $order = Order::find($data['id']);
        return ['url' => $order->get_payment_url($final_price)];
    }

    public function retry_payment(Request $request)
    {
        $data = $request->json()->all();
        $order = Order::find($data['id']);
        $final_price = 0;
        foreach ($order->goods as $good) {
            $final_price += $good->price * $good->pivot->quantity;
        };
        return $order->get_payment_url($final_price);
    }

    function http_response($data, int $response_type)
    {
        return \response()->json(
            $data, $response_type,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }

    function success(int $response_type)
    {
        return self::http_response(['status' => 'success'], $response_type);
    }

    function bad_request($error)
    {
        return self::http_response(
            ['status' => 'error', 'error' => $error],
            Response::HTTP_BAD_REQUEST);
    }
}
