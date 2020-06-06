<?php

namespace App\Http\Controllers\API;

use App\Good;
use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UsersDataController extends Controller
{

    public function update(Request $request)
    {
        $data = $request->all();
        if(key_exists('id',$data)) {
            $model = User::withTrashed()->get()->where('id', $data['id'])->first();
        } elseif ($user = \auth('api')->user()) {
            $model = $user->getModel();
        }
        if($model)
        {
            //Files
            $path_directory = '/images/avatars/';
            if (!empty($data['avatar']) && $request->hasfile('avatar')) {
                if (!file_exists(public_path() . $path_directory))
                    mkdir(public_path() . $path_directory);
                $file = $request->file('avatar');
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $filename =time().'.'.$extension;
                $file->move(public_path() . $path_directory, $filename);
                $data['avatar'] = asset($path_directory. $filename);
            }

            $model->fill($data);

            $validator = Validator::make($data, User::$validate_update);
            if ($validator->fails())
                return self::bad_request($validator->errors());
            $model->save();
            return self::success($data);
        }
        return self::bad_request('Пользователь с данным ID не найден');
    }

    public function destroy(Request $request)
    {
        $data = $request->json()->all();
        if ($model = User::withTrashed()->get()->where('id', $data['id'])->first()) {
            $model->delete();
            return self::success();
        }
        return self::bad_request('Пользователь с данным ID не найден');
    }

    public function restore(Request $request)
    {
        $data = $request->json()->all();
        if ($model = User::withTrashed()->get()->where('id', $data['id'])->first()) {
            $model->restore();
            return self::success();
        }
        return self::bad_request('Пользователь с данным ID не найден');
    }

    public function profit_chart()
    {
        $user = \auth('api')->user();

        $orders = Order::whereIn('status_id',[Order::STATUS_FINISHED, Order::STATUS_PAID])->with('goods')->whereHas('goods',
            function ($good) use ($user) {
                $good->where('user_id', '=', $user->id);
            })->orderBy('updated_at')->get()->toArray();

        $i = 0;
        foreach ($orders as $order) {
            $orders[$i]['goods'] = array_filter($order['goods'],
                function ($good) use ($user) {
                    return $good['user_id'] === $user->id;
                });
            $i++;
        }

        $output = [];
        foreach ($orders as $order) {
            $date = Carbon::parse($order['updated_at'])->format('d.m.Y');
            $cash = 0;
            foreach ($order['goods'] as $good)
                $cash += $good['pivot']['price_current'] * $good['pivot']['quantity'] * (1-$good['pivot']['tax_current']);
            if(isset($output[$date]))
                $output[$date] += round($cash, 2);
            else
                $output[$date] = round($cash, 2);
        }
        return ['data' => $output];
    }

    function http_response($data, int $response_type)
    {
        return \response()->json(
            $data, $response_type,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }

    function success($data = [])
    {
        return self::http_response(['status' => 'success','data' => $data], Response::HTTP_OK);
    }

    function bad_request($error)
    {
        return self::http_response(
            ['status' => 'error', 'error' => $error],
            Response::HTTP_BAD_REQUEST);
    }
}
