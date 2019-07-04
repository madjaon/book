<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostChap extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'postchaps';

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
        'post_id',
        'volume',
        'chapter',
        'position',
        'view',
        'lang',
        'status',
        'start_date',
    ];

    public function post() 
    {
        return $this->belongsTo('App\Models\Post', 'post_id', 'id');
    }
}
