<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostModel extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $primaryKey = 'post_id';

    protected $fillable = [
        'author_user_id',
        'anonymous',
        'parent_post_id',
        'audience_id',
        'duration',
        'visibility_location_id',
        'topic_id',
        'post_content',

    ];
}
