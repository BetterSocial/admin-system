<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PostModel extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $primaryKey = 'post_id';
    public $incrementing = false;
    protected $keyType = 'string';


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

    public function getUsernameAttribute()
    {
        return $this->user->username ?? '-';
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Topics::class, 'post_topics', 'post_id', 'topic_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(UserApps::class, 'author_user_id', 'user_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(UserPostComment::class, 'post_id', 'getstream_activity_id');
    }

    public function statistic(): HasOne
    {
        return $this->hasOne(PostStatisticModel::class, 'post_id', 'getstream_activity_id');
    }
}
