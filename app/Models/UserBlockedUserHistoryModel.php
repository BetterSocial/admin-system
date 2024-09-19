<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBlockedUserHistoryModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'user_blocked_user_history';
    protected $primaryKey = 'user_blocked_user_history_id';
    protected $fillable = [
        'user_id_blocker',
        'user_id_blocked',
        'source',
        'action'
    ];
}
