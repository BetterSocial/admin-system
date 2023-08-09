<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class PostScoreModel extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'post_score';
}
