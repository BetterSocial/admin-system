<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollowDomailHistoryModel extends Model
{
    use HasFactory;
    protected $table = 'user_follow_domain_history';
    protected $primaryKey = 'follow_domain_history_id';
    protected $fillable = [
        'user_id_follower',
        'domain_id_followed',
        'action',
        'source',
    ];
}
