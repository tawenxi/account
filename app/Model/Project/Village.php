<?php

namespace App\Model\Project;

use Illuminate\Database\Eloquent\Model;
use App\Model\Project\Project;

class Village extends Model
{
	public $fillable = ['name','describe','shuji','year'];
    public $timestamps = false;

    public function projects()
    {
    	return $this->hasMany(Project::class);
    }
}
