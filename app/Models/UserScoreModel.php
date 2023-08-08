<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class UserScoreModel extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'user_score';

    protected $fillable = [
        'user_score',
    ];
}
