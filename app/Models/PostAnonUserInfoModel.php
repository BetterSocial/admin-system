<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostAnonUserInfoModel extends Model
{
    use HasFactory;
    protected $table = 'post_anon_user_info';
    protected $fillable = [
        'post_id',
        'anon_user_id',
        'anon_user_info_color_name',
        'anon_user_info_color_code',
        'anon_user_info_emoji_name',
        'anon_user_info_emoji_code',
    ];
}
