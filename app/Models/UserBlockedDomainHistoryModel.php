<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBlockedDomainHistoryModel extends Model
{
    use HasFactory;
    protected $table = 'user_blocked_domain_history';
    protected $primaryKey = 'user_blocked_domain_history_id';
    protected $fillable = [
        'user_id_blocker',
        'domain_page_id',
    ];
}
