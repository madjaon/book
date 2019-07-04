<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostSeri extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'postseries';

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
    ];

    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'summary',
        'content',
        'image',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'meta_image',
        'lang',
        'status',
        'start_date',
    ];
    
}
