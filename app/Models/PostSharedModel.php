<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostSharedModel extends Model
{
    use HasFactory;
    protected $table = 'post_shared';
    protected $primaryKey = 'post_id';
}
