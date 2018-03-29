<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Boss extends Model
{
    public $fillable = ['name','bank','bankaccount','supportpoor','description','totalpayout','payoutcount'];
    public $timestamps = False;

}
