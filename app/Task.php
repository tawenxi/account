<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	public $timestamps = false;
    public $fillable = ['SKR','SKYH','SKZH','ZFFS','ZY','amount','beizhu','done','label','tagged'];
}
