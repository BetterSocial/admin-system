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

    public function topic()
    {
        return $this->belongsTo(Topics::class, 'topic_id');
    }

    public function scopeFilterSearchName($query, $searchTerm)
    {
        return $query->with('topic')->whereHas('topic', function ($query) use ($searchTerm) {
            $query->where('name', 'like', '%' . $searchTerm . '%');
        });
    }
}
