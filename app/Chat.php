<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Chat
 *
 * @property int $id
 * @property string|null $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Message[] $messages
 * @property-read int|null $messages_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Chat whereName($value)
 * @mixin \Eloquent
 */
class Chat extends Model
{
    protected $table = 'chats';

    protected $fillable = [
        'name'
    ];

    public static $validate = [
        'name' => ['string'],
    ];

    public $timestamps = false;

    public function users()
    {
        return $this->belongsToMany(User::class, 'parties',
            'chat_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
