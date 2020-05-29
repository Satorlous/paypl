<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class UsersDataController extends Controller
{

    public function update(Request $request)
    {
        $data = $request->all();
        if($model = User::withTrashed()->get()->where('id', $data['id'])->first())
        {
            $model->fill($data);

            $validator = Validator::make($data, User::$validate_update);
            if ($validator->fails())
                return self::bad_request($validator->errors());
            $model->save();
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
            return self::success();
        }
        return self::bad_request('Пользователь с данным ID не найден');
    }

    public function destroy(Request $request)
    {
        $data = $request->json()->all();
        if($model = User::withTrashed()->get()->where('id', $data['id'])->first())
        {
            $model->delete();
            return self::success();
        }
        return self::bad_request('Пользователь с данным ID не найден');
    }

    public function restore(Request $request)
    {
        $data = $request->json()->all();
        if($model = User::withTrashed()->get()->where('id', $data['id'])->first())
        {
            $model->restore();
            return self::success();
        }
        return self::bad_request('Пользователь с данным ID не найден');
    }

    function http_response($data, int $response_type)
    {
        return \response()->json(
            $data, $response_type,
            ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],
            JSON_UNESCAPED_UNICODE
        );
    }

    function success()
    {
        return self::http_response(['status' => 'success'], Response::HTTP_OK);
    }

    function bad_request($error)
    {
        return self::http_response(
            ['status' => 'error', 'error' => ['id' => $error]],
            Response::HTTP_BAD_REQUEST);
    }
}
