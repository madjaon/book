<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTagRelation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'posttagrelations';

    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
        'post_id',
        'posttag_id',
    ];

    public function post() 
    {
        return $this->belongsTo('App\Models\Post', 'post_id', 'id');
    }
    public function posttag() 
    {
        return $this->belongsTo('App\Models\PostTag', 'posttag_id', 'id');
    }
}
