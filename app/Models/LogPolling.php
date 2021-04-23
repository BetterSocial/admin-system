<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPolling extends Model
{
    use HasFactory;
    protected $table    = 'log_polling_id';
    protected $primaryKey = 'log_polling_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    const CREATED_AT    = 'created_at';
    const UPDATED_AT    = 'updated_at';
}
