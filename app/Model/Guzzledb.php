<?php

namespace App\Model;

use App\Model\ZB;
use App\Scopes\GuzzledbScope;
use App\Model\Respostory\Guzzle;
use App\Model\Respostory\DataSource;
use App\Model\Respostory\HandleArray;
use Illuminate\Database\Eloquent\Model;

class Guzzledb extends Model
{
    public $tables;

    public $mybody;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new GuzzledbScope);
    }

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

    





    /**
     *
     * 生成新的数据源(生成明码mybody，并且返回$this)
     * @return $this
     *
     */
    
    public function generateMybody()
    {
        $this->mybody = (new DataSource($this))->mybody;
        return $this;
    }

    /**
     *
     * 对生成的Mybody 进行加密操作，一般用在 generateMybody() 之后
     *  @return $mybody (明码)
     */
    

    public function encodeMybody()
    {
        $this->mybody = encode($this->mybody);
        return $this->mybody;
    }

    
    /**
     *
     * 根据加密的body进行分析，提取出数组数据
     * @param $id 第几张表格
     * @param $body 需要进行分析的数据源  如果不传入则为数据库中的body字段
     * @retuen Array
     */
    
    public function getArray($id, $body=null)
    {
        return (new DataSource($this))->getArray($id, $body);
    }

    /**
     *
     * 进行数据的双body 验证
     *
     */

    public function comparebody()
    {
        $accountdata = ['zhaiyao'=>'zhaiyao',
                        'amount'=>1,
                        'payee'=>'罗旭东',
                        'payeeaccount'=>'1781577500001008',
                        'payeebanker'=>'中国工商银行',
                        'zbid'=>$this->ZBID];
        $guzzle = app(Guzzle::class);
        $mybody = $guzzle->setPayee($accountdata)
                         ->setCompareBody($this->generateMybody()->encodeMybody())
                         ->handleCompareBody();

        $originBody = $guzzle->setPayee($accountdata)
                             ->setCompareBody()
                             ->handleCompareBody();
                    //dd($originBody,$mybody);
        return $mybody === $originBody;
    }

    public function zb()
    {
        return $this->belongsTo(\App\Zb::class,'ZBID','ZBID');
    }
    
}
