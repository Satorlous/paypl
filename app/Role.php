<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Role
 *
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereName($value)
 * @mixin \Eloquent
 */
class Role extends Model
{
    const ROLE_ADMIN  = 1;
    const ROLE_SELLER = 2;
    const ROLE_BUYER  = 3;


    protected $table = 'roles';

    protected $fillable = [
        'name'
    ];

    public static $validate = [
        'name'  => ['required', 'string']
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }

}
