<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Topics extends Model
{

    protected $table    = 'topics';
    protected $primaryKey = 'topic_id';
    protected $fillable = ['name','icon_path','categories','created_at'];
    const CREATED_AT    = 'createdon';
    public $timestamps = false;
  
}
