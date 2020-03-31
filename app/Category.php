<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
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
        return $this->hasMany(Category::class, 'parent_id');
    }
}
