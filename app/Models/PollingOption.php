<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PollingOption extends Model
{
    use HasFactory;
    protected $table    = 'polling_option';
    protected $primaryKey = 'polling_option_id';
    public $incrementing = false;
    protected $keyType = 'uuid';
    const CREATED_AT    = 'created_at';
    const UPDATED_AT    = 'updated_at';
}
