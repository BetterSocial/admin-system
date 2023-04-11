<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogErrorModel extends Model
{
    use HasFactory;

    protected $table = "log_errors";

    protected $fillable = [
        'message'
    ];
}
