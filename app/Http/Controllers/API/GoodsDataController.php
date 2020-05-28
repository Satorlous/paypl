<?php

namespace App\Http\Controllers\API;

use App\Good;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class GoodsDataController extends Controller
{
    function store(Request $request)
    {
        $data = $request->json()->all();
        $validator = Validator::make($data, Good::$validate);
        if($validator->fails())
            return self::http_response(
                ['status' => 'error', 'error' => $validator->errors()],
                Response::HTTP_BAD_REQUEST);
        Good::create($data);
        return self::http_response(['status' => 'success'], Response::HTTP_CREATED);
    }

    function update(Request $request)
    {
        $data = $request->json()->all();
        if($model = Good::withTrashed()->get()->where('id', $data['id'])->first())
        {
            $model->fill($data);
            $validator = Validator::make($model->toArray(), Good::$validate);
            if ($validator->fails())
            {
                return self::http_response(
                    ['status' => 'error', 'error' => $validator->errors()],
                    Response::HTTP_BAD_REQUEST);
            }
            $model->save();
            return self::http_response(['status' => 'success'], Response::HTTP_OK);
        }
        return self::http_response(
            ['status' => 'error', 'error' => ['id' => 'Товар с данным ID не найден']],
            Response::HTTP_BAD_REQUEST);
    }

    function destroy(Request $request)
    {
        $data = $request->json()->all();
        if($model = Good::withTrashed()->get()->where('id', $data['id'])->first())
        {
            $model->delete();
            return self::http_response(['status' => 'success'], Response::HTTP_OK);
        }
        return self::http_response(
            ['status' => 'error', 'error' => ['id' => 'Товар с данным ID не найден']],
            Response::HTTP_BAD_REQUEST);
    }

    function restore(Request $request)
    {
        $data = $request->json()->all();
        if($model = Good::withTrashed()->get()->where('id', $data['id'])->first())
        {
            $model->restore();
            return self::http_response(['status' => 'success'], Response::HTTP_OK);
        }
        return self::http_response(
            ['status' => 'error', 'error' => ['id' => 'Товар с данным ID не найден']],
            Response::HTTP_BAD_REQUEST);
    }

    function http_response($data, int $response_type)
    {
        return \response()->json(
            $data, $response_type,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }
}
