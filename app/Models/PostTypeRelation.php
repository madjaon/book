<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTypeRelation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posttyperelations';

    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'posttype_id',
    ];

    public function post() 
    {
        return $this->belongsTo('App\Models\Post', 'post_id', 'id');
    }
    public function posttype() 
    {
        return $this->belongsTo('App\Models\PostType', 'posttype_id', 'id');
    }
}
