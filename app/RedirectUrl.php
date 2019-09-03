<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RedirectUrl extends Model
{   
    private $rules = [
        'hash' => 'string',
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