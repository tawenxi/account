<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Zjzb extends Model implements Transformable
{
    use TransformableTrait;

    public $timestamps = false;
    public $guarded = [];


    public function zb()
    {
    	return $this->belongsTo(\App\Model\Zb::class,'ZBID','ZBID');
    }
}
