<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostStatisticModel extends Model
{
    use HasFactory;
    protected $table = 'post_statistic';
    protected $primaryKey = 'post_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'view_count',
        'upvote_count',
        'downvote_count',
        'block_count',
        'shared_count',
        'comment_count',
    ];

    public function post()
    {
        return $this->belongsTo(PostModel::class, 'post_id', 'getstream_activity_id');
    }
}
