<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Zfpz extends Model
{
    use SearchableTrait;
    public $timestamps = false;

    public function getZySkrAttribute()
    {
        return $this->attributes['ZY'].' '.$this->attributes['SKR'].' '.$this->attributes['JE'];
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_number', 'account_number');
    }

    public function scopeHasaccount($query, $account=false)
    {
        if (!$account) {
            return $query->where('account_number', '')->orwhere('account_number', null);
        }

        return $query;
    }

    public function zb()
    {
        return $this->belongsTo(Zb::class, 'ZBID', 'ZBID');
    }

    public function setJeAttribute($amount)
    {

        $this->attributes['JE'] = $amount * 100;
        //dd($this->attributes['JE']);
    }

    public function getJeAttribute($amount)
    {
        return bcdiv($this->attributes['JE'], 100, 2);
    }

    protected $fillable = [
            'XH',
            'KJND',
            'PDQJ',
            'PDH',
            'PDRQ',
            'DJBH',
            'YSDWDM',
            'ZY',
            'SKR',
            'QS_RQ',
            'SKZH',
            'SKRKHYH',
            'FKR',
            'FKZH',
            'FKRKHYH',
            'ZBID',
            'JE',
            'DZKMC',
            'YSDWMC',
            'YSDWQC',
            'ZJXZMC',
            'JSFSMC',
            'YSKMMC',
            'YSKMQC',
            'JFLXMC',
            'JFLXQC',
            'ZFFSMC',
            'ZCLXMC',
            'ZBLYMC',
            'XMMC',
            'YSGLLXMC',
            'NEWDYBZ',
            'NEWZZPZ',
            'NEWPZLY',
            'NEWZT',
            'NEWCXBZ',
            'MXZBWH',
            'BJWH',
            'account_number',
];
}
