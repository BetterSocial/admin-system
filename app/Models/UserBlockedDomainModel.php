<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBlockedDomainModel extends Model
{
    use HasFactory;
    protected $table = 'user_blocked_domain';
    protected $primaryKey = 'user_blocked_domain_id';
    protected $fillable = [
        'user_id_blocker',
        'domain_page_id',
        'reason_blocked'
    ];
}
