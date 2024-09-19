<?php

namespace App\Models;

// use Jenssegers\Mongodb\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostScoreModel extends Model
{
    // protected $connection = 'mongodb';
    // protected $collection = 'post_score';

    use HasFactory;
    protected $table = 'post_score';
    protected $primaryKey = 'post_score_id';
    protected $fillable = [
        'feed_id',
        'post_score'
    ];
}
