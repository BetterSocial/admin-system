<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTopicModel extends Model
{
    use HasFactory;
    protected $table = 'user_topics';
    protected $primaryKey = 'user_topics_id';
    protected $fillable = [
        'user_id',
        'topic_id',
    ];

    public function user()
    {
        return $this->belongsTo(UserApps::class, 'user_id', 'user_id');
    }

    public function topic()
    {
        return $this->belongsTo(Topics::class, 'topic_id', 'topic_id');
    }
}
