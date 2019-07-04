<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'configs';

    /**
     * Fillable fields for a Profile.
     *
     * @var array
     */
    protected $fillable = [
        'headercode',
        'footercode',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'meta_image',
        'fb_app_id',
        'lang',
    ];
}
