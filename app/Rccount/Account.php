<?php

namespace App\Rccount;

use Nicolaslopezj\Searchable\SearchableTrait;

class Account extends \LaravelArdent\Ardent\Ardent
{
    use SearchableTrait;
    protected $searchable = [
      'columns' => [
        'GL_Pznr.zy'   => 10,
        'GL_Pznr.je'   => 10,
        'GL_Pznr.kmdm' => 5,
        'GL_Pznr.kjqj' => 10,
        ],
    ];
    public $timestamps = false;
    public $table = 'GL_Pznr';

    public function getJieAttribute($value)
    {
        if ($this->attributes['jdbz'] == '借') {
            return $this->attributes['je'];
        } else {
            return 0;
        }
    }

    public function getDaiAttribute($value)
    {
        if ($this->attributes['jdbz'] == '贷') {
            return $this->attributes['je'];
        } else {
            return 0;
        }
    }

    public function getBalanceAttribute($value)
    {
        if ($this->attributes['jdbz'] == '贷') {
            return $this->attributes['je'];
        } else {
            return '';
        }
    }
}
