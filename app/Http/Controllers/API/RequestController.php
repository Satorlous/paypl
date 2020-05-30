<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class RequestController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->json()->all();
        $user = \auth('api')->user();
        $data['status_id'] = \App\Request::STATUS_PROCESSING;
        $data['user_id'] = $user->id;
        $validator = \Validator::make($data, \App\Request::$validate);
        if ($validator->fails())
            return self::bad_request($validator->errors());

        if (\App\Request::whereUserId($data['user_id'])->count()) {
            return self::http_response(['status' => 'error', 'error' => 'Заявка уже подана'], Response::HTTP_OK);
        }
        \App\Request::create($data);
        return self::success(Response::HTTP_CREATED);
    }

    public function update(Request $request)
    {
        $data = $request->json()->all();
        if ($model = \App\Request::find($data['id']))
        {
            if($data['accepted']) {
                $model->status_id = \App\Request::STATUS_ACCEPTED;
                $model->save();

                $user = User::find(\auth('api')->user()->id);
                $user->role_id = Role::ROLE_BUYER;
                $user->save();
            }
            else {
                $model->status_id = \App\Request::STATUS_DECLINED;
                $model->save();
            }
            return $this->success(Response::HTTP_OK);
        }
        return $this->bad_request('Model ID not found');
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
