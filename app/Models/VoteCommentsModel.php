<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoteCommentsModel extends Model
{
    use HasFactory;
    protected $table = 'vote_comments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'comment_id',
        'user_id',
        'status'
    ];
}
