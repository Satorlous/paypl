<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Request
 *
 * @property int $id
 * @property int $user_id
 * @property int $status_id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Status $status
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Request newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Request newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Request query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Request whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Request whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Request whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Request whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Request whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Request whereUserId($value)
 * @mixin \Eloquent
 */
class Request extends Model
{
    const STATUS_PROCESSING = 100;
    const STATUS_DECLINED = 101;
    const STATUS_ACCEPTED = 102;

    protected $table = 'requests';

    protected $fillable = [
        'user_id', 'status_id', 'content'
    ];

    public static $validate = [
        'user_id' => ['required', 'exists:App\User,id'],
        'status_id' => ['required', 'exists:App\Status,id'],
        'content' => ['required', 'string'],
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
