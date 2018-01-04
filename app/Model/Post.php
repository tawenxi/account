<?php

namespace App\Model;

use App\Model\Tt\RecordsActivity;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use RecordsActivity;
	public $guarded = [];
}
