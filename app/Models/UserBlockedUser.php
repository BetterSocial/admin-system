<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserBlockedUser extends Model
{
    use HasFactory;
    protected $table    = 'user_blocked_user';
    protected $primaryKey = 'blocked_action_id';
    protected $fillable = [
        'user_id_blocker',
        'user_id_blocked',
        'reason_blocked'
    ];

    public static function postByBlocked()
    {

        $sql = "SELECT post_id, COUNT(*) AS total_blocked FROM user_blocked_user WHERE post_id != 'null' GROUP BY post_id ORDER BY total_blocked desc";
        return DB::select($sql);
    }
}
