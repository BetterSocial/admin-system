<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Topics extends Model
{
    protected $table    = 'topics';
    protected $fillable = ['topicId','name','iconPath','categories'];
    const CREATED_AT    = 'createdon';
  
}
