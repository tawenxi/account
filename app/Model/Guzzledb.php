<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Guzzledb extends Model
{
    //
    public $fillable = ['DZKDM', 'DZKMC', 'YSDWDM', 'YSDWMC', 'ZJXZDM', 'ZJXZMC', 'ZFFSDM', 'YSKMDM', 'YSKMMC', 'JFLXDM', 'JFLXMC', 'ZCLXDM', 'ZCLXMC', 'XMDM', 'XMMC', 'ZBLYDM', 'ZBLYMC', 'ZJLYMC', 'YKJHZB', 'YYJHJE', 'KYJHJE', 'YSGLLXDM',  'YSGLLXMC', 'NEWYSKMDM', 'ZBID', 'ZY', 'ZBWH', 'body', 'ZBID','useable'];

    public function payouts()
    {
        return $this->hasMany('App\Model\Payout', 'zbid', 'ZBID');
    }

    public function setYkjhzbAttribute($amount)
    {
        $this->attributes['YKJHZB'] = beint100($amount);
    }

    public function getYkjhzbAttribute($amount)
    {
        return div($this->attributes['YKJHZB']/100);
    }

    public function setYyjhjeAttribute($amount)
    {
        $this->attributes['YYJHJE'] = beint100($amount);
    }

    public function getYyjhjeAttribute($amount)
    {
        return div($this->attributes['YYJHJE']/100);
    }

    public function setKyjhjeAttribute($amount)
    {
        $this->attributes['KYJHJE'] = beint100($amount);
    }

    public function getKyjhjeAttribute($amount)
    {
        return div($this->attributes['KYJHJE']/100);
    }
}
