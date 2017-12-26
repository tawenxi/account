<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use App\Model\Tt\Sqarray;
use App\Model\ZB;


class Guzzledb extends Model
{
    use Sqarray;

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


    public function updateSqarray()
    {
        $this->table1['Dzkdm'] = "'$this->DZKDM'";
        $this->table1['Ysdwdm'] = "'$this->YSDWDM'";

        $this->table2['ZBID'] = "'$this->ZBID'";
        $this->table2['zjxzdm'] = "'$this->ZJXZDM'";
        $this->table2['Yskmdm'] = "'$this->YSKMDM'";
        $this->table2['Jflxdm'] = "'$this->JFLXDM'";
        $this->table2['ysgllxdm'] = "'$this->YSGLLXDM'";
        $this->table2['zblydm'] = "'$this->ZBLYDM'";
        $this->table2['xmdm'] = "'$this->XMDM'";

        $this->table3['DZKMC'] = "'$this->DZKMC'";
        $this->table3['XMMC'] = "'$this->XMMC'";
        $this->table3['MXZBWH'] = "'$this->ZBWH'";
        $this->table3['MXZBXH'] = "{$this->findInZb('MXZBXH')}";
        $this->table3['ZBLYMC'] = "'{$this->ZBLYMC}'";
        $this->table3['ZJXZMC'] = "'{$this->findInZb('ZJXZMC')}'";
        $this->table3['YSKMMC'] = "'{$this->YSKMMC}'";
        $this->table3['YSKMQC'] = "'{$this->findInZb('YSKMQC')}'";
        $this->table3['JFLXMC'] = "'{$this->JFLXMC}'";

        switch ($this->JFLXMC) {
            case '其他商品和服务支出':
                $jjfl = '商品和服务支出-其他商品和服务支出';
                break;
            
            case '其他支出':
                $jjfl = '其他支出-其他支出';
                break;
            default:
            throw new Exception('全称错误');
        }
        $this->table3['JFLXQC'] = "'{$jjfl}'";
        $this->table3['YSGLLXMC'] = "'{$this->YSGLLXMC}'";

        return $this;
    }


    public function findInZb ($attribute)
    {
        return ZB::where('ZBID', $this->ZBID)->value($attribute);
    }




    public function generateSqData ()
    {
        extract($this->updateSqarray()->table1);
        $tawenxi1 = sprintf('%s, %s, %s,  %s,%s,  %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s, %s, %s, %s, %s, %s, %s, %s,%s,%s, %s, %s,%s,%s, %s ,%s,%s,%s,%s',$Gsdm,$Kjnd,$Pdqj,$Pdh,$zflb,$Djbh,$xjbz,$zphm,$Pdrq,$Dzkdm,$Ysdwdm,$Fkrdm,$Fkr,$Fkryhbh,$Fkzh,$Fkrkhyh,$Fkyhhh,$PJPCHM,$Skrdm,$Skr,$Skryhbh,$Skzh,$Skrkhyh,$Skyhhh,$Zy,$FJS,$lrr_ID,$lrr,$lr_rq,$dwshr_id,$dwshr,$dwsh_rq,$cxbz,$bz2,$zt,$dybz,$ZZPZ);
        unset($Gsdm,$Kjnd,$Pdqj,$Pdh,$zflb,$Djbh,$xjbz,$zphm,$Pdrq,$Dzkdm,$Ysdwdm,$Fkrdm,$Fkr,$Fkryhbh,$Fkzh,$Fkrkhyh,$Fkyhhh,$PJPCHM,$Skrdm,$Skr,$Skryhbh,$Skzh,$Skrkhyh,$Skyhhh,$Zy,$FJS,$lrr_ID,$lrr,$lr_rq,$dwshr_id,$dwshr,$dwsh_rq,$cxbz,$bz2,$zt,$dybz,$ZZPZ);
        extract($this->updateSqarray()->table2);

        $tawenxi2 = sprintf('%s, %s, %s, %s, %s,  %s, %s,%s,%s,%s,  %s,  %s,  %s,  %s,  %s,  %s,  %s,  %s,  %s, %s, %s, %s, %s, %s, %s,  %s,  %s,  %s',$Gsdm,$Kjnd,$JHID,$ZBID,$Pdqj,$Pdh,$pdxh,$zflb,$LINKID,$zjxzdm,$jsfsdm,$Yskmdm,$Jflxdm,$zffsdm,$zclxdm,$ysgllxdm,$zblydm,$xmdm,$SJWH,$BJWH,$YWLXDM,$XMFLDM,$KZZLDM1,$KZZLDM2,$zbje,$yyzbje,$kyzbje,$JE);
        unset($Gsdm,$Kjnd,$JHID,$ZBID,$Pdqj,$Pdh,$pdxh,$zflb,$LINKID,$zjxzdm,$jsfsdm,$Yskmdm,$Jflxdm,$zffsdm,$zclxdm,$ysgllxdm,$zblydm,$xmdm,$SJWH,$BJWH,$YWLXDM,$XMFLDM,$KZZLDM1,$KZZLDM2,$zbje,$yyzbje,$kyzbje,$JE);
        extract($this->updateSqarray()->table3);
        $tawenxi3 = sprintf('%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',$GSDM,$KJND,$ZFLB,$PDH,$PDQJ,$JSFSMC,$NEWDYBZ,$NEWZZPZ,$NEWCXBZ,$NEWPZLY,$NEWZT,$PDXH,$DZKMC,$XMMC,$XMFLMC,$YSDWMC,$YSDWQC,$YWLXMC,$ZFFSMC,$MXZBWH,$MXZBXH,$ZBLYMC,$ZJXZMC,$YSKMMC,$YSKMQC,$JFLXMC,$JFLXQC,$ZCLXMC,$YSGLLXMC,$KZZLMC1,$KZZLMC2);
        unset($GSDM,$KJND,$ZFLB,$PDH,$PDQJ,$JSFSMC,$NEWDYBZ,$NEWZZPZ,$NEWCXBZ,$NEWPZLY,$NEWZT,$PDXH,$DZKMC,$XMMC,$XMFLMC,$YSDWMC,$YSDWQC,$YWLXMC,$ZFFSMC,$MXZBWH,$MXZBXH,$ZBLYMC,$ZJXZMC,$YSKMMC,$YSKMQC,$JFLXMC,$JFLXQC,$ZCLXMC,$YSGLLXMC,$KZZLMC1,$KZZLMC2);

        return $result = strtr($this->sqmoban, compact('tawenxi1','tawenxi2','tawenxi3'));
    }


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

         $body = $body?$body:$this->body;
        $result = $this->_getTable($body,$key,$value);
        return $result;
    }

    private function _getTable($data,$regex1 ,$regex2) 
    {
        preg_match($regex1, 
                   iconv('GB2312', 'UTF-8',
                   urldecode($data)), 
                   $res);

        $table1_key = explode(',', str_replace(' ', '', $res[0]));

        preg_match($regex2, 
                   iconv('GB2312', 
                   'UTF-8',
                   urldecode($data)), 
                   $res);

        $table1_value = preg_split("/(?<!date),(?!'培训')/", 
                                   str_replace(' ', '', $res[0]));

        return $table = array_combine($table1_key, $table1_value);
    }
}
