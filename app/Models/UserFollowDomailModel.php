<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollowDomailModel extends Model
{
    use HasFactory;
    protected $table = 'user_follow_domain';
    protected $primaryKey = 'follow_action_id';
    protected $fillable = [
        'domain_id_followed'
    ];
}
