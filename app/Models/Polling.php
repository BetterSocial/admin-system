<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polling extends Model
{
    use HasFactory;
    protected $table    = 'polling';
    protected $primaryKey = 'polling_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    const CREATED_AT    = 'created_at';
    const UPDATED_AT    = 'updated_at';

    public function post()
    {
        return $this->belongsTo(PostModel::class, 'post_id', 'post_id');
    }
}
