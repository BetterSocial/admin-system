<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBlockedPostAnonymousModel extends Model
{
    use HasFactory;
    protected $table = 'user_blocked_post_anonymous';
    protected $primaryKey = 'blocked_action_id';
    protected $fillable = [
        'user_id_blocker',
        'post_anonymous_id_blocked',
        'reason_blocked',
        'post_anonymous_author_id',
    ];
}
