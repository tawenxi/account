<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $timestamps = false;
    protected $fillable = ['account_number', 'name','account_name','isuseful'];

    public function zbDetails()
    {
        return hasmany(ZbDetail::class, 'account_number', 'account_number');
    }

    public function zbs()
    {
        return hasmany(zb::class, 'account_number', 'account_number');
    }
}
