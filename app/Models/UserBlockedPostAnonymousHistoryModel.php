<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBlockedPostAnonymousHistoryModel extends Model
{
    use HasFactory;
    protected $table = 'user_blocked_post_anonymous_history';
    protected $primaryKey = 'user_blocked_post_anonymous_history_id';
    protected $fillable = [
        'user_id_blocker',
        'post_anonymous_id_blocked',
        'action',
        'source',
    ];
}
