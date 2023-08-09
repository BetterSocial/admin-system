<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class UserPostScoreModel extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'user_post_score';
}
