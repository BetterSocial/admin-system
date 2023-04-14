<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class LogModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'logs';

    protected $fillable = [
        'title',
        'description',
        'created_by'
    ];

    public static function insertLog($title, $description)
    {
        $user = Auth::user();
        LogModel::create([
            'title' => $title,
            'description' => $description,
            'created_by' => $user->name
        ]);
    }
}
