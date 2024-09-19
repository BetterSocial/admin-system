<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostDownvotedModel extends Model
{
    use HasFactory;
    protected $table = 'post_downvoted';
    protected $primaryKey = 'post_id';
    protected $fillable = [
        'user_id'
    ];
}
