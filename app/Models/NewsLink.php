<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class NewsLink extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'news_link';
    protected $primaryKey= 'news_link_id';
    public $incrementing = false;
    protected $keyType = 'string';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'domain_page_id',
        'site_name',
        'title',
        'image',
        'description',
        'url',
        'keyword',
        'author',

        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [ ];

}
