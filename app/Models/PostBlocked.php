<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostBlocked extends Model
{
    use HasFactory;

    protected $table = 'post_blocked';
    protected $primaryKey = 'post_id';
}
