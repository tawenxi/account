<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\ZbDetail;
use App\Model\zb;

class Account extends Model
{
	public $timestamps=false;
    protected $fillable = ['account_number','name'];
    public function zbDetails()
    {
    	return hasmany(ZbDetail::class,'account_number','account_number');
    }
    public function zbs()
    {
    	return hasmany(zb::class,'account_number','account_number');
    }
}
