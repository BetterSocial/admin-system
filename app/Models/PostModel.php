<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'post_content',
        'getstream_activity_id',
    ];

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Topics::class, 'post_topics', 'post_id', 'topic_id');
    }
}
