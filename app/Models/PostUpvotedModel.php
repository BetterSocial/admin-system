<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostUpvotedModel extends Model
{
    use HasFactory;
    protected $table = 'post_upvoted';
    protected $primaryKey = 'post_id';
}
