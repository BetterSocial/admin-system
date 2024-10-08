<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostDownvotedModel extends Model
{
    use HasFactory;
    protected $table = 'post_downvoted';
    protected $primaryKey = 'post_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'user_id'
    ];
}
