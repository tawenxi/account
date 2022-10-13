<?php

namespace App\Model\Respostory;

use App\Model\Tt\Data;
use App\Model\Guzzledb;

/**

    TODO:
    - 传入Guzzledb模型生产数据模型generateMybody()->mybody
    - 根据mybody生成数组数据
    - Second todo item

 */

class DataSource
{
    use Data;
    public $mybody;
    public $yourbody;
    public $guzzledb;
    public $tableToreplaced;

    /* 可以分析出本授权指标《替换的组数数据》 */
    /* 可以分析新生成的《new body》 */
    
    public function __construct(Guzzledb $guzzledb)
    {
        $this->guzzledb = $guzzledb;
        $this->yourbody = decode($guzzledb->body);
        $this->tableToreplaced = (new HandleArray($guzzledb))->updateSqarray();
        $this->generateMybody();
    }


    public function generateMybody()
    {
        extract($this->tableToreplaced[0]);
        $tawenxi1 = sprintf('%s, %s, %s,  %s,%s,  %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s,%s, %s, %s, %s, %s, %s, %s, %s,%s,%s, %s, %s,%s,%s, %s ,%s,%s,%s,%s',$Gsdm,$Kjnd,$Pdqj,$Pdh,$zflb,$Djbh,$xjbz,$zphm,$Pdrq,$Dzkdm,$Ysdwdm,$Fkrdm,$Fkr,$Fkryhbh,$Fkzh,$Fkrkhyh,$Fkyhhh,$PJPCHM,$Skrdm,$Skr,$Skryhbh,$Skzh,$Skrkhyh,$Skyhhh,$Zy,$FJS,$lrr_ID,$lrr,$lr_rq,$dwshr_id,$dwshr,$dwsh_rq,$cxbz,$bz2,$zt,$dybz,$ZZPZ);
        unset($Gsdm,$Kjnd,$Pdqj,$Pdh,$zflb,$Djbh,$xjbz,$zphm,$Pdrq,$Dzkdm,$Ysdwdm,$Fkrdm,$Fkr,$Fkryhbh,$Fkzh,$Fkrkhyh,$Fkyhhh,$PJPCHM,$Skrdm,$Skr,$Skryhbh,$Skzh,$Skrkhyh,$Skyhhh,$Zy,$FJS,$lrr_ID,$lrr,$lr_rq,$dwshr_id,$dwshr,$dwsh_rq,$cxbz,$bz2,$zt,$dybz,$ZZPZ);
        extract($this->tableToreplaced[1]);

        $tawenxi2 = sprintf('%s, %s, %s, %s, %s,  %s, %s,%s,%s,%s,  %s,  %s,  %s,  %s,  %s,  %s,  %s,  %s,  %s, %s, %s, %s, %s, %s, %s,  %s,  %s,  %s',$Gsdm,$Kjnd,$JHID,$ZBID,$Pdqj,$Pdh,$pdxh,$zflb,$LINKID,$zjxzdm,$jsfsdm,$Yskmdm,$Jflxdm,$zffsdm,$zclxdm,$ysgllxdm,$zblydm,$xmdm,$SJWH,$BJWH,$YWLXDM,$XMFLDM,$KZZLDM1,$KZZLDM2,$zbje,$yyzbje,$kyzbje,$JE);
        unset($Gsdm,$Kjnd,$JHID,$ZBID,$Pdqj,$Pdh,$pdxh,$zflb,$LINKID,$zjxzdm,$jsfsdm,$Yskmdm,$Jflxdm,$zffsdm,$zclxdm,$ysgllxdm,$zblydm,$xmdm,$SJWH,$BJWH,$YWLXDM,$XMFLDM,$KZZLDM1,$KZZLDM2,$zbje,$yyzbje,$kyzbje,$JE);
        extract($this->tableToreplaced[2]);
        $tawenxi3 = sprintf('%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s',$GSDM,$KJND,$ZFLB,$PDH,$PDQJ,$JSFSMC,$NEWDYBZ,$NEWZZPZ,$NEWCXBZ,$NEWPZLY,$NEWZT,$PDXH,$DZKMC,$XMMC,$XMFLMC,$YSDWMC,$YSDWQC,$YWLXMC,$ZFFSMC,$MXZBWH,$MXZBXH,$ZBLYMC,$ZJXZMC,$YSKMMC,$YSKMQC,$JFLXMC,$JFLXQC,$ZCLXMC,$YSGLLXMC,$KZZLMC1,$KZZLMC2);
        unset($GSDM,$KJND,$ZFLB,$PDH,$PDQJ,$JSFSMC,$NEWDYBZ,$NEWZZPZ,$NEWCXBZ,$NEWPZLY,$NEWZT,$PDXH,$DZKMC,$XMMC,$XMFLMC,$YSDWMC,$YSDWQC,$YWLXMC,$ZFFSMC,$MXZBWH,$MXZBXH,$ZBLYMC,$ZJXZMC,$YSKMMC,$YSKMQC,$JFLXMC,$JFLXQC,$ZCLXMC,$YSGLLXMC,$KZZLMC1,$KZZLMC2);

        $this->mybody = strtr($this->sqmoban(), compact('tawenxi1','tawenxi2','tawenxi3'));
        return $this;
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

        $body = $body?encode($body):$this->yourbody;
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

    
}
