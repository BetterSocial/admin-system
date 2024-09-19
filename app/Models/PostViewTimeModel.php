<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostViewTimeModel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'post_view_time';
    protected $primaryKey = 'post_id';
    protected $fillable = [
        'user_id',
        'view_time',
        'source,'
    ];
}
