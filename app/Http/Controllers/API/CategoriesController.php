<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Good;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    //ToDo: категории возвращают лишнюю информацию: slug и parent_id, проблема в collections и objects при
    //  при указании определенных полей
    public function getMap()
    {
        return
            Category::all(['id', 'name', 'slug', 'parent_id', 'tax'])->whereStrict('parent_id', null)->each(
                function ($item) {
                    $item['children'] = $item->getChildren();
                    unset($item['parent_id']);
                })->toArray();
    }

    public function getCategory(Request $request)
    {
        $aRequest = $request->json()->all();
        if (empty($aRequest['category'])) {
            $categories = Category::all()->whereStrict('parent_id', null)->values()->toArray();
            $products = Good::all()->forPage($aRequest['page'], $aRequest['count'])
                ->values()->each(
                    function ($good) {
                        if (count($good->media) > 0) {
                            $good->media_link = $good->media->first()->link;
                        } else {
                            $good->media_link = '';
                        }
                        $good['category_slug'] = $good->category->slug;
                    });
            $pages = ceil(Good::all()->count() / $aRequest['count']);
        } else {
            $category = Category::all()->firstWhere('slug', '=', $aRequest['category']);
            $categories_id = [$category->id];

            if ($category->parent_id == null) {
                if ($category->children->count() == 0) {
                    $categories = Category::all()->whereStrict('parent_id', null);
                } else {
                    $categories = Category::all()->whereStrict('parent_id', null);
                    foreach ($category->getCHildren() as $child) {
                        $categories_id[] = $child['id'];
                    }
                }
            } else {
                if ($category->children->count() == 0) {
                    $categories = Category::all()->where('parent_id', '=', $category->parent_id)
                        ->values()->toArray();
                } else {
                    $categories = Category::all()->where('parent_id', '=', $category->parent_id)
                        ->values()->toArray();
                    foreach ($category->getChildren() as $child) {
                        $categories_id[] = $child['id'];
                    }
                }
            }

            $products = Good::all()->whereIn('category_id', $categories_id)
                ->forPage($aRequest['page'], $aRequest['count'])->values()
                ->each(
                    function ($good) {
                        if (count($good->media) > 0) {
                            $good->media_link = $good->media->first()->link;
                        } else {
                            $good->media_link = '';
                        }
                        $good['category_slug'] = $good->category->slug;
                    });
            $pages = ceil(
                Good::all()->whereIn('category_id', $categories_id)->count()
                / $aRequest['count']);
        }
        return [
            'categories' => $categories,
            'products' => $products,
            'pages' => $pages,
        ];
    }

    public function getBreadcrumbs($slug = '', $product = '')
    {
        $category = Category::all()->firstWhere('slug', '=', $slug);
        $aResult = [['name' => 'Каталог', 'link' => '/catalog']];
        if ($category) {
            $aBuf = [];
            if ($category->parent_id == null) {
                $aBuf[] = ['name' => $category->name, 'link' => "/catalog/{$category->slug}"];
            } else {
                do {
                    $aBuf[] = ['name' => $category->name, 'link' => "/catalog/{$category->slug}"];
                    $category = $category->parent;
                } while ($category->parent_id != null);
            }
            array_push($aResult, ...array_reverse($aBuf));
        }
        if (!empty($product)) {
            $good = Good::all()->firstWhere('slug','=',$product);
            if ($good) {
                array_push($aResult, ['name' => $good->name,'link' => '']);
            }
        }
        return $aResult;
    }

}
