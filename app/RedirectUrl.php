<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RedirectUrl extends Model
{   
    private $rules = [
        'long_url' => 'required'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'long_url'
    ];
}