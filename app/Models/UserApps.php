<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserApps extends Model
{

    use HasFactory;
    protected $table    = 'users';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'string';
    const CREATED_AT    = 'created_at';
    const UPDATED_AT    = 'updated_at';

    protected $fillable = [
        'is_banned'
    ];

    public function userTopics()
    {
        return $this->hasMany(UserTopicModel::class, 'user_id', 'user_id');
    }
}
