<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Cat extends Model implements Transformable
{
    use TransformableTrait;

    public $table = 'salaries';

    protected $fillable = [];

}
