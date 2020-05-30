<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Good;
use App\Http\Controllers\Controller;
use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Self_;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class GoodsDataController extends Controller
{
    function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, Good::$validate);
        if($validator->fails())
            return self::bad_request([$validator->errors()]);
        $data['category_id'] = Category::whereSlug($data['category_slug'])->first()->id;
        $data['user_id'] = \auth('api')->user()->id;
        $good = Good::create($data);
        //Files
        $path_directory = '/images/media/';
        if (!empty($data['medias']))
        {
            if (!file_exists(public_path() . $path_directory))
                mkdir(public_path() . $path_directory);

            $path_directory .= $good->id.'/';
            mkdir(public_path() . $path_directory);

            for ($i =0; true; ++$i)
            {
                if (!$request->hasFile("media_$i")) {
                    break;
                }
                $file = $request["media_$i"];
                $extension = $file->getClientOriginalExtension();
                $filename = time(). $i.'.'.$extension;
                $file->move(public_path() . $path_directory, $filename);
                $full_file_path = asset($path_directory.$filename);
                $media = Media::create(
                    [
                        'good_id' => $good->id,
                        'link' => $full_file_path,
                        'media_type_id' => 1
                    ]
                );
            }
        }
        return self::success(Response::HTTP_CREATED);
    }

    function update(Request $request)
    {
        $data = $request->all();
        if($model = Good::withTrashed()->get()->where('id', $data['id'])->first())
        {
            $model->fill($data);
            $validator = Validator::make($model->toArray(), Good::$validate_update);
            if ($validator->fails())
                return self::bad_request($validator->errors());
            $model->save();
            //Files
            $path_directory = '/images/media/'.$model->id.'/';
            if (!empty($data['medias']))
            {
                if (!file_exists(public_path() . $path_directory))
                    mkdir(public_path() . $path_directory);

                $path_directory .= $model->id.'/';
                (public_path() . $path_directory);

                for ($i =0; true; ++$i)
                {
                    if (!$request->hasFile("media_$i")) {
                        break;
                    }
                    $file = $request["media_$i"];
                    $extension = $file->getClientOriginalExtension();
                    $filename = time(). $i.'.'.$extension;
                    $file->move(public_path() . $path_directory, $filename);
                    $full_file_path = asset($path_directory.$filename);
                    $media = Media::create(
                        [
                            'good_id' => $model->id,
                            'link' => $full_file_path,
                            'media_type_id' => 1
                        ]
                    );
                }
            }
            return self::success(Response::HTTP_OK);
        }
        return self::bad_request(['id' => 'Товар с данным ID не найден']);
    }

    function destroy(Request $request)
    {
        $data = $request->json()->all();
        if($model = Good::withTrashed()->get()->where('id', $data['id'])->first())
        {
            $model->delete();
            return self::success(Response::HTTP_OK);
        }
        return self::bad_request(['id' => 'Товар с данным ID не найден']);
    }

    function restore(Request $request)
    {
        $data = $request->json()->all();
        if($model = Good::withTrashed()->get()->where('id', $data['id'])->first())
        {
            $model->restore();
            return self::success(Response::HTTP_OK);
        }
        return self::bad_request(['id' => 'Товар с данным ID не найден']);
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
