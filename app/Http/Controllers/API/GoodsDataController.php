<?php

namespace App\Http\Controllers\API;

use App\Good;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class GoodsDataController extends Controller
{
    function test(Request $request)
    {
        return Good::find(10);
    }

    function store(Request $request)
    {
        $data = $request->json()->all();
        $validator = Validator::make($data, Good::$validate);
        if($validator->fails())
            return \response()->json(
                ['status' => 'error', 'error' => $validator->errors()],
                Response::HTTP_BAD_REQUEST,
                ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
                JSON_UNESCAPED_UNICODE
            );
        Good::create($data);
        return \response()->json(
            ['status' => 'success'],
            Response::HTTP_CREATED,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }

    function update(Request $request)
    {

    }

    function destroy(Request $request)
    {

    }
}
