<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public $guarded = [];


    public function user()
    {
    	return $this->belongsTo(\App\User::class);
    }

    public function subject()
    {
    	return $this->morphTo();
    }
}
