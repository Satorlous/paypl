<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Good;
use App\Http\Controllers\Controller;
use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class GoodsDataController extends Controller
{
    function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, Good::$validate);
        if($validator->fails())
            return self::bad_request($validator->errors());
        $data['category_id'] = Category::whereSlug($data['category_slug'])->first()->id;
        $good = Good::create($data);
        //Files
        $path_directory = '/images/media/'.$good->id.'/';
        if (!empty($data['medias']) && $request->hasfile('medias'))
        {
            if (!file_exists(public_path() . $path_directory))
                mkdir(public_path() . $path_directory);
            $files = $request->file('medias');

            foreach ($files as $file)
            {
                $extension = $file->getClientOriginalExtension();
                $filename = time().'.'.$extension;
                $file->move(public_path() . $path_directory, $filename);
                $full_file_path = asset($path_directory.$filename);
                Media::create(
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
            $validator = Validator::make($model->toArray(), Good::$validate);
            if ($validator->fails())
                return self::bad_request($validator->errors());
            $model->save();
            //Files
            $path_directory = '/images/media/'.$model->id.'/';
            if (!empty($data['medias']) && $request->hasfile('medias')) {
                if (!file_exists(public_path() . $path_directory)) {
                    mkdir(public_path() . $path_directory);
                }
                $files = $request->file('medias');
                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = time().'.'.$extension;
                    $file->move(public_path() . $path_directory, $filename);
                    $full_file_path = asset($path_directory.$filename);
                    Media::create(
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
        return self::bad_request('Товар с данным ID не найден');
    }

    function destroy(Request $request)
    {
        $data = $request->json()->all();
        if($model = Good::withTrashed()->get()->where('id', $data['id'])->first())
        {
            $model->delete();
            return self::success(Response::HTTP_OK);
        }
        return self::bad_request('Товар с данным ID не найден');
    }

    function restore(Request $request)
    {
        $data = $request->json()->all();
        if($model = Good::withTrashed()->get()->where('id', $data['id'])->first())
        {
            $model->restore();
            return self::success(Response::HTTP_OK);
        }
        return self::bad_request('Товар с данным ID не найден');
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
            ['status' => 'error', 'error' => ['id' => $error]],
            Response::HTTP_BAD_REQUEST);
    }
}
