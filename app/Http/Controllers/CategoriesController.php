<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function getMap()
    {
        return ['categories' => Category::all()->whereStrict('parent_id', null)->each(
            function ($item) {
                $item['children'] = $this->getChildren($item);
            })->toArray()];
    }

    /**
     * Рекурсивный метод получения дочерних категорий
     *
     * @param Category|null $parent
     *
     * @return array
     *
     */
    private function getChildren($parent)
    {
        $aResult = [];
        $children = $parent->children;
        foreach ($children as $child) {
            $aResult[$child->id] = $child->toArray();
            $aResult[$child->id]['children'] = $this->getChildren($child);
        }
        return $aResult;
    }

    /**
     * Возвращает главную родительскую категорию
     *
     * @param Category $category
     *
     * @return mixed
     */
    private function getMainParent($category)
    {
        if($category->parent != null) {
            return $this->getMainParent($category->parent);
        } else {
            return $category;
        }
    }
}
