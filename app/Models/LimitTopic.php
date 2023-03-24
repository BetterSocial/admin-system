<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LimitTopic extends Model
{
    use HasFactory;

    protected $table = 'limit_topics';

    protected $fillable = ['limit'];
}
