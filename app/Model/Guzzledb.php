<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Tt\Sqarray;
use App\Model\ZB;
use App\Model\Respostory\Guzzle;


class Guzzledb extends Model
{
    use Sqarray;

    public $mybody;

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

    private function _validataChanging($data)
    {
        if ($data === NULL) {
            throw new \Exception('NULL出现了');
        }
        return $data;
    }


    public function updateSqarray()
    {
        $this->table1['Dzkdm'] = "'{$this->_validataChanging($this->DZKDM)}'";
        $this->table1['Ysdwdm'] = "'{$this->_validataChanging($this->YSDWDM)}'";

        $this->table2['ZBID'] = "'{$this->_validataChanging($this->ZBID)}'";
        $this->table2['zjxzdm'] = "'{$this->_validataChanging($this->ZJXZDM)}'";
        $this->table2['Yskmdm'] = "'{$this->_validataChanging($this->YSKMDM)}'";
        $this->table2['Jflxdm'] = "'{$this->_validataChanging($this->JFLXDM)}'";
        $this->table2['ysgllxdm'] = "'{$this->_validataChanging($this->YSGLLXDM)}'";
        $this->table2['zblydm'] = "'{$this->_validataChanging($this->ZBLYDM)}'";
        $this->table2['xmdm'] = "'{$this->_validataChanging($this->XMDM)}'";
        $this->table2['YWLXDM'] = "'{$this->_validataChanging($this->_findInZb('YWLXDM'))}'";
        $this->table2['XMFLDM'] = "'{$this->_validataChanging($this->_findInZb('XMFLDM'))}'";



        $this->table3['YSDWMC'] = "'{$this->_validataChanging($this->YSDWMC)}'";
        $this->table3['YSDWQC'] = "'{$this->_validataChanging($this->YSDWMC)}'";
        $this->table3['DZKMC'] = "'{$this->_validataChanging($this->DZKMC)}'";
        $this->table3['XMMC'] = "'{$this->_validataChanging($this->XMMC)}'";
        $this->table3['MXZBWH'] = "'{$this->_validataChanging($this->_findInZb('MXZBWH'))}'";
        $this->table3['MXZBXH'] = "{$this->_validataChanging($this->_findInZb('MXZBXH'))}";
        $this->table3['ZBLYMC'] = "'{$this->_validataChanging($this->ZBLYMC)}'";
        $this->table3['ZJXZMC'] = "'{$this->_validataChanging($this->_findInZb('ZJXZMC'))}'";
        $this->table3['YSKMMC'] = "'{$this->_validataChanging($this->YSKMMC)}'";
        $this->table3['YSKMQC'] = "'{$this->_validataChanging($this->_findInZb('YSKMQC'))}'";
        $this->table3['JFLXMC'] = "'{$this->_validataChanging($this->JFLXMC)}'";

        switch ($this->JFLXMC) {
            case '其他商品和服务支出':
                $jjfl = '商品和服务支出-其他商品和服务支出';
                break;
            
            case '其他支出':
                $jjfl = '其他支出-其他支出';
                break;
            case '基础设施建设':
                $jjfl = '基本建设支出-基础设施建设';
                break;
            case '其他基本建设支出':
                $jjfl = '基本建设支出-其他基本建设支出';
                break;
            default:
            throw new \Exception('全称错误'.$this->JFLXMC);
        }
        $this->table3['JFLXQC'] = "'{$this->_validataChanging($jjfl)}'";
        $this->table3['YSGLLXMC'] = "'{$this->_validataChanging($this->YSGLLXMC)}'";

        return $this;
    }


    private function _findInZb ($attribute)
    {
        return ZB::where('ZBID', $this->ZBID)->value($attribute);
    }



    /**
     *
     * 生成新的数据源(生成明码mybody，并且返回$this)
     * @return $this
     *
     */
    
    public function generateMybody()
    {
        $this->updateSqarray();
        extract($this->updateSqarray()->table1);
        $tawenxi1 = sprintf('%s, %s, %s,  %s,%s,  %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s, %s, %s, %s, %s, %s, %s, %s,%s,%s, %s, %s,%s,%s, %s ,%s,%s,%s,%s',$Gsdm,$Kjnd,$Pdqj,$Pdh,$zflb,$Djbh,$xjbz,$zphm,$Pdrq,$Dzkdm,$Ysdwdm,$Fkrdm,$Fkr,$Fkryhbh,$Fkzh,$Fkrkhyh,$Fkyhhh,$PJPCHM,$Skrdm,$Skr,$Skryhbh,$Skzh,$Skrkhyh,$Skyhhh,$Zy,$FJS,$lrr_ID,$lrr,$lr_rq,$dwshr_id,$dwshr,$dwsh_rq,$cxbz,$bz2,$zt,$dybz,$ZZPZ);
        unset($Gsdm,$Kjnd,$Pdqj,$Pdh,$zflb,$Djbh,$xjbz,$zphm,$Pdrq,$Dzkdm,$Ysdwdm,$Fkrdm,$Fkr,$Fkryhbh,$Fkzh,$Fkrkhyh,$Fkyhhh,$PJPCHM,$Skrdm,$Skr,$Skryhbh,$Skzh,$Skrkhyh,$Skyhhh,$Zy,$FJS,$lrr_ID,$lrr,$lr_rq,$dwshr_id,$dwshr,$dwsh_rq,$cxbz,$bz2,$zt,$dybz,$ZZPZ);
        extract($this->updateSqarray()->table2);

        $tawenxi2 = sprintf('%s, %s, %s, %s, %s,  %s, %s,%s,%s,%s,  %s,  %s,  %s,  %s,  %s,  %s,  %s,  %s,  %s, %s, %s, %s, %s, %s, %s,  %s,  %s,  %s',$Gsdm,$Kjnd,$JHID,$ZBID,$Pdqj,$Pdh,$pdxh,$zflb,$LINKID,$zjxzdm,$jsfsdm,$Yskmdm,$Jflxdm,$zffsdm,$zclxdm,$ysgllxdm,$zblydm,$xmdm,$SJWH,$BJWH,$YWLXDM,$XMFLDM,$KZZLDM1,$KZZLDM2,$zbje,$yyzbje,$kyzbje,$JE);
        unset($Gsdm,$Kjnd,$JHID,$ZBID,$Pdqj,$Pdh,$pdxh,$zflb,$LINKID,$zjxzdm,$jsfsdm,$Yskmdm,$Jflxdm,$zffsdm,$zclxdm,$ysgllxdm,$zblydm,$xmdm,$SJWH,$BJWH,$YWLXDM,$XMFLDM,$KZZLDM1,$KZZLDM2,$zbje,$yyzbje,$kyzbje,$JE);
        extract($this->updateSqarray()->table3);
        $tawenxi3 = sprintf('%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',$GSDM,$KJND,$ZFLB,$PDH,$PDQJ,$JSFSMC,$NEWDYBZ,$NEWZZPZ,$NEWCXBZ,$NEWPZLY,$NEWZT,$PDXH,$DZKMC,$XMMC,$XMFLMC,$YSDWMC,$YSDWQC,$YWLXMC,$ZFFSMC,$MXZBWH,$MXZBXH,$ZBLYMC,$ZJXZMC,$YSKMMC,$YSKMQC,$JFLXMC,$JFLXQC,$ZCLXMC,$YSGLLXMC,$KZZLMC1,$KZZLMC2);
        unset($GSDM,$KJND,$ZFLB,$PDH,$PDQJ,$JSFSMC,$NEWDYBZ,$NEWZZPZ,$NEWCXBZ,$NEWPZLY,$NEWZT,$PDXH,$DZKMC,$XMMC,$XMFLMC,$YSDWMC,$YSDWQC,$YWLXMC,$ZFFSMC,$MXZBWH,$MXZBXH,$ZBLYMC,$ZJXZMC,$YSKMMC,$YSKMQC,$JFLXMC,$JFLXQC,$ZCLXMC,$YSGLLXMC,$KZZLMC1,$KZZLMC2);

        $this->mybody = strtr($this->sqmoban, compact('tawenxi1','tawenxi2','tawenxi3'));
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
        $table1_regex1 = "/Gsdm,Kjnd,Pdqj,Pdh.+dybz,ZZPZ/";
        $table1_regex2 = "/(?<!values \() '001'.+'0' ,'0','0','0','0'/";

        $table2_regex1 = "/Gsdm,Kjnd,JHID,ZBID,Pdqj,Pdh.+yyzbje,kyzbje,JE/";
        $table2_regex2 = "/(?<!select) '001'.+\d{1,}(\.[0-9]{1,2})?,\s*\d{1,}(\.[0-9]{1,2})?,\s*\d{0,}(\.[0-9]{1,2})?,\s*\d{1,}(\.[0-9]{1,2})?/";

        $table3_regex1 = "/GSDM,KJND,ZFLB,PDH.+KZZLMC1,KZZLMC2/";
        $table3_regex2 = "/001','20\d{2,2}','0'.+','',''/";  

        switch ($id) {
             case 1:
                 $key = $table1_regex1;
                 $value = $table1_regex2;
                 break;
             case 2:
                 $key = $table2_regex1;
                 $value = $table2_regex2;
                 break;
             case 3:
                 $key = $table3_regex1;
                 $value = $table3_regex2;
                 break;
             
             default:
                 throw new Exception('只能输入123');
                 break;
         } 

        $body = $body?encode($body):$this->body;
        $result = $this->_getTable($body,$key,$value);
        return $result;
    }


    //传入的是加密的data
    private function _getTable($data,$regex1 ,$regex2) 
    {
        preg_match($regex1, decode($data), $res);

        $table1_key = explode(',', str_replace(' ', '', $res[0]));

        preg_match($regex2, decode($data), $res);

        $table1_value = preg_split("/(?<!date),(?!'培训')/", 
                                   str_replace(' ', '', $res[0]));

        return $table = array_combine($table1_key, $table1_value);
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
    
}
