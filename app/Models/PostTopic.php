<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostTopic extends Model
{
    use HasFactory;
    protected $table = 'post_topics';
    protected $fillable = [
        'post_id',
        'topic_id',
    ];
}
