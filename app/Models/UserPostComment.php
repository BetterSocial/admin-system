<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPostComment extends Model
{
    use HasFactory;
    protected $table    = 'user_post_comment';
    protected $primaryKey = 'id';

    protected $fillable = [
        'post_id',
        'parent_comment_id',
        'comment_id',
        'author_user_id',
        'commenter_user_id',
        'is_anonymous',
        'comment'
    ];

    public function user()
    {
        return $this->belongsTo(UserApps::class, 'author_user_id', 'user_id');
    }
}
