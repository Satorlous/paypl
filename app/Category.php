<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'name', 'tax', 'parent_id'
    ];

    public static $validate = [
        'name'        => ['required', 'string'],
        'tax'         => ['required', 'double'],
        'parent_id'   => ['exists:App\Category,id'],
    ];

    public $timestamps = false;

    public function goods()
    {
        return $this->hasMany(Good::class, 'category_id','id');
    }

    /**
     * Возвращает родительскую категорию
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Возвращает подкатегории
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id','id');
    }

    /**
     * Рекурсивный метод получения дочерних категорий
     *
     * @return array
     *
     */
    public function getChildren()
    {
        $aResult = [];
        $children = $this->children;
        foreach ($children as $child) {
            $aResult[$child->id] = $child->toArray();
            $aResult[$child->id]['children'] = $child->getChildren();
        }
        return $aResult;
    }

    /**
     * Возвращает главную родительскую категорию
     *
     * @return mixed
     */
    private function getMainParent()
    {
        if($this->parent != null) {
            return $this->parent->getMainParent();
        } else {
            return $this;
        }
    }
}
