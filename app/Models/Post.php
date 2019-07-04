<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posts';

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
        'images',
        'type_main_id',
        'type',
        'seri',
        'nation',
        'kind',
        'view',
        'rating_value',
        'rating_count',
        'lang',
        'status',
        'start_date',
    ];
    
    public function posttyperelations()
    {
        return $this->hasMany('App\Models\PostTypeRelation', 'post_id', 'id');
    }
    public function posttypes()
    {
        return $this->belongsToMany('App\Models\PostType', 'posttyperelations', 'post_id', 'posttype_id');
    }
    public function posttagrelations()
    {
        return $this->hasMany('App\Models\PostTagRelation', 'post_id', 'id');
    }
    public function posttags()
    {
        return $this->belongsToMany('App\Models\PostTag', 'posttagrelations', 'post_id', 'posttag_id');
    }
    public function postchaps()
    {
        return $this->hasMany('App\Models\PostChap', 'post_id', 'id');
    }
}
