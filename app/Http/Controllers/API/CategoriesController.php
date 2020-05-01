<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    //ToDo: категории возвращают лишнюю информацию: slug и parent_id, проблема в collections и objects при
    //  при указании определенных полей
    public function getMap()
    {
        return ['categories' => Category::all(['id','name','slug','parent_id'])->whereStrict('parent_id', null)->each(
            function ($item) {
                $item['children'] = $item->getChildren();
                unset($item['parent_id']);
            })->toArray()];
    }

}
