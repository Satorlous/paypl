<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Category
 *
 * @property int $id
 * @property string $name
 * @property float $tax
 * @property int|null $parent_id
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Category[] $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Good[] $goods
 * @property-read int|null $goods_count
 * @property-read \App\Category|null $parent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Category onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category whereTax($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Category withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Category withoutTrashed()
 * @mixin \Eloquent
 */
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
