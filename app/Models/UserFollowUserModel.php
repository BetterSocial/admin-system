<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollowUserModel extends Model
{
    use HasFactory;
    protected $table    = 'user_follow_user';
    protected $primaryKey = 'follow_action_id';

    /**
     * user_id_follower => userId yang mengikuti
     * user_id_followed => id yang di ikuti
     */
    protected $fillable = [
        'user_id_follower',
        'user_id_followed',
        'followed_at',
        'is_anonymous',
    ];
    public $incrementing = false;

    public function follower()
    {
        return $this->belongsTo(UserApps::class, 'user_id_follower', 'user_id');
    }

    public function followed()
    {
        return $this->belongsTo(UserApps::class, 'user_id_followed', 'user_id');
    }
}
