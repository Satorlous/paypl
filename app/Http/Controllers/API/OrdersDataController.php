<?php

namespace App\Http\Controllers\API;

use App\Good;
use App\Http\Controllers\Controller;
use App\Order;
use App\Status;
use Illuminate\Http\Request;

class OrdersDataController extends Controller
{

    public function orderListByBuyer(Request $request)
    {
        $data = $request->json()->all();
        $orders = Order::where(
            [
                'user_id' => $data['user_id'],
                'status_id' => $data['status_id'],
            ])
            ->with('goods')
            ->get()->forPage($data['page'], $data['count']);
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

    }
}
