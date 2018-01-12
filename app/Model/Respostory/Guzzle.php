<?php

namespace App\Model\Respostory;

use App\Model\Guzzledb;
use App\Model\Payout;
use App\Model\Test;
use App\Model\Tt\Data;
use App\Model\Tt\Replace;
use App\Model\Tt\Zhibiao;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Guzzle extends Model
{
    use Zhibiao;
    use Data;
    use Replace;
    public $insertbody; //发送post的dq部分
    public $payee = []; //需要替换的银行信息
    public $data;  //用来转化utf->GBK
    public $balancebody; //查询余额的dp
    private $amountData; //[金额数据]
    private $rizhiData; //[日志数据]
    private $http; //[日志数据]

    public function __construct(Getsqzb $Getsqzb, Http $http)
    {
        $this->Getsqzb = $Getsqzb;
        $this->http = $http;
    }

    public function setPayee(Array $payee)
    {
        $this->payee = $payee;
        return $this;
    }
//   ->setPayee()->setBody()
    private $_bodySaving;
    public function setBody()
    {
        $zb = Guzzledb::where('ZBID', $this->payee['zbid'])->firstOrFail();
        $this->insertbody = trim($zb->body);
        $this->_bodySaving = trim($zb->body);

        if (!$this->validateSql()) {
                    throw new Exception('验证数据源错误');
        } 
        return $this;
    }


public function setCompareBody($body = NULL)
    {
        if (!is_null($body) && strlen($body)>3000) {

            $this->insertbody = trim($body);
        } else {
            $zb = Guzzledb::where('ZBID', $this->payee['zbid'])->firstOrFail();
            $this->insertbody = trim($zb->body);
                $search = [
                    '190207313396'      =>'178190121002547948',
                    '99900114'          =>'',
                    '吉安遂川县财政局'  =>'叶涛',
                    '中行遂川支行'      =>'遂川县农商合作银行',
                    "'005'"             =>"'_'",
                    '99991528'          => '',
                ];
                
                $this->insertbody = encode(strtr(decode($this->insertbody), $search));  
                $this->insertbody = encode(preg_replace("/'\d+', 'zhaiyao'/", "'_', 'zhaiyao'", decode($this->insertbody)));
                $this->insertbody = encode(preg_replace("/'\d+', '叶涛', '\d+'/", "'', '叶涛', ''", decode($this->insertbody)));
                //dd(decode($this->insertbody));              
        }
        return $this;
    }

    public function validateSql()
    {
        $zbid = $this->payee['zbid'];
        $zbidmowei = substr($zbid, -4);
        $pattern = "/<?xml version.+from zb_zfpzdjbh.+\d{10,40}.+zhaiyao.+$zbidmowei.+<\/R9PACKET>/";
        $vali_result = preg_match($pattern, decode($this->insertbody));
        return $vali_result?TRUE:FALSE;
    }

    /**
     * TODO:
     * - 设置amountData.
     */
    private function setAmountData($amount)
    {
        $pattern = '/\d{1,}(\.[0-9]{1,2})?,\s*\d{1,}(\.[0-9]{1,2})?,\s*\d{0,}(\.[0-9]{1,2})?,\s*\d{1,}(\.[0-9]{1,2})?/';
        preg_match($pattern, $amount, $res);
        //dd($amount,$res);
        if ($res[0] === $amount) {
            $this->amountData = $amount;
        } else {
            throw new Exception('[amount]数据异常'.__LINE__, 1);
        }
    }

    private function getAmountData()
    {
        if (empty($this->amountData)) {
            throw new Exception('[amount]数据异常'.__LINE__, 1);
        } else {
            return $this->amountData;
        }
    }

    /**
     * TODO:
     * - 设置rizhiData.
     */
    private function setRizhiData($rizhi)
    {
        $pattern = "/\[001,.+\]/";
        preg_match($pattern, $rizhi, $res);
        if ($res[0] === $rizhi) {
            $this->rizhiData = $rizhi;
        } else {
            throw new Exception('[rizhi]数据异常'.__LINE__, 1);
        }
    }

    private function getRizhiData()
    {
        if (empty($this->rizhiData)) {
            throw new Exception('[amount]数据异常'.__LINE__, 1);
        } else {
            return $this->rizhiData;
        }
    }


    /**
     *
     * 测试
     *
     */
    public function test_input(){
        if ($this->payee['amount'] <= 0 OR
            !is_numeric($this->payee['amount'])) {
            throw new Exception('金额不能小于 且必须为数值');
        }elseif ($this->payee['zhaiyao']=='zhaiyao'){
            throw new Exception('摘要必须修改');
        } elseif (substr($this->payee['zbid'], 0,11) != '001.'.config('app.MYND').'.0.' OR 
            strlen($this->payee['zbid']) != 15 AND
            strlen($this->payee['zbid']) != 16 ) {
            throw new Exception('指标格式不正确'.substr($this->payee['zbid'], 0,11));
        }  elseif (!is_numeric($this->payee['payeeaccount'])) {
            throw new Exception('账号非全数值');
        }  elseif (!is_numeric($this->payee['amount'])) {
            throw new Exception('账号非全数值');
        } elseif (strpos($this->payee['amount'],'.') !== FALSE AND ((int)substr($this->payee['amount'], strpos($this->payee['amount'],'.')+1) > 100)){
            throw new Exception('输入了多位小数:'.$this->payee['amount']);
        } else {
            if ($this->payee['payee'] == '遂川县枚江镇财政所2') {
                $this->payee['payee'] = '遂川县枚江镇财政所';
            }
            $this->payee['amount'] = div($this->payee['amount']);
        };
    }


    /**
     *
     * 处理数据源
     *  @return 处理后的明码数据源
     */
    
    public function handleBody()
    {
        Test::log(__METHOD__.'根据一行数据获取对象的指标信息');
        $zb = $this->get_zbdata($this->payee['zbid']); //获取最新数据

        if ($zb['KYJHJE'] < $this->payee['amount']) {
            Test::log('!!!金额不足');
            throw new Exception("指标不足：{$zb['KYJHJE']}小于{$this->payee['amount']}");
        }
        Test::log(__METHOD__.'验证金额足够');

        $zb['YKJHZB'] = div($zb['YKJHZB']);
        $zb['YYJHJE'] = div($zb['YYJHJE']);
        $zb['KYJHJE'] = div($zb['KYJHJE']);
        $this->payee['amount'] = div($this->payee['amount']);

        $zbamount = $zb['YKJHZB'].','.$zb['YYJHJE'].','.$zb['KYJHJE'].','.$this->payee['amount'];
        Test::log(__METHOD__.'生成金额数据');
        $this->accountreplace($this->payee);
        $this->amountreplace($zbamount);
        $this->insertbody = $this->timereplace($this->insertbody,5,3,1);
        Test::log(__METHOD__.'替换时间金额账户信息');

        //--------------------------------------------
        return iconv('GB2312', 'UTF-8', $this->insertbody);
    }



/**
     *
     * 处理数据源
     *  @return 处理后的明码数据源
     */
    
    public function handleCompareBody()
    {
        $zb['YKJHZB'] = '10000.00';
        $zb['YYJHJE'] = '10000.00';
        $zb['KYJHJE'] = '10000.00';
        $this->payee['amount'] = div($this->payee['amount']);
        $zbamount = $zb['YKJHZB'].','.$zb['YYJHJE'].','.$zb['KYJHJE'].','.$this->payee['amount'];
        $this->accountreplace($this->payee);
        $this->amountreplace($zbamount);
        $this->insertbody = $this->timereplace($this->insertbody,5,3,1);
        return iconv('GB2312', 'UTF-8', $this->insertbody);
    }

    
    private function compare2body()
    {
        foreach ([1,2] as $_value) {
            $guzzledb = new Guzzledb();
            $nowBody = $guzzledb->getArray($_value,iconv('GB2312','UTF-8', $this->insertbody));
            $startBody = $guzzledb->getArray($_value,decode($this->_bodySaving));
            $diff= collect($nowBody)->diffAssoc($startBody)
                                 ->keys()->toArray();
            $result = collect($diff)->each(function ($value, $key)use ($_value) 
            {
                    switch ($_value) {
                        case 1:
                            $changed = [ "Kjnd","Pdqj","Pdrq","Skrdm","Skr","Skryhbh","Skzh","Zy"];
                            break;
                        case 2:
                            $changed = ["Kjnd","Pdqj","zbje","yyzbje","kyzbje","JE"];
                            break;
                    }
                    $bool = in_array($value, $changed);
                    if (!$bool) dd('compare比较数组错误（guzzle.php:243）');
            });
        }
    }
    /**
     * TODO:发送制单请求
     * - 传入@
     * - 返回@response.
     */
    public function add_post()
    {
        $this->test_input();
        $vali_var = $this->handleBody();
        $this->compare2body();     
        if (stristr($vali_var, $this->payee['payeeaccount']) and 
            stristr($vali_var, $this->payee['amount']) and 
            stristr($vali_var, $this->payee['payee']) and 
            stristr($vali_var, $this->payee['payeebanker']) and 
            stristr($vali_var, $this->payee['zhaiyao']) and
            stristr($vali_var, "'178157750000004662', '农商行枚江分理处', '012'") and
            //确保银行数据接收
            !strstr($vali_var, config('app.MYND'))//
            )
        {
            dd('ok');
            //dd($this->insertbodyody);
            //这里的insertBody的一个非中文的半明码
            $response2 = $this->http->makerequest($this->insertbody);
            Test::log(__METHOD__.'发送POST请求');
        }else {
            throw new Exception('POST前验证替换效果失败');
        } 
        
        /*=============================================
        =            进行日志增加            =
        =============================================*/
        $response3 = (string) ($response2);
        if (stristr($response3, 'RES=')) {
            preg_match('/RES="\d+"/', $response3, $pid);
            preg_match('/\d+/', $pid[0], $pid);
            $pid = (string) $pid[0];
            preg_match('/DJBH="\d+"/', $response3, $djbh);
            preg_match('/\d+/', $djbh[0], $djbh);
            $djbh = (string) $djbh[0];
            Test::log(__METHOD__.'获取RESPONSE中的PID和DJBH');
            /*==================================
            =            记录增加的sql日志            =
            ==================================*/
            \App\Model\Sql::create(['pid'=>$pid, 'type'=>'addshouquan', 'djbh'=>$djbh, 'sql'=>iconv('GB2312', 'UTF-8', $this->insertbody)]);
            Test::log(__METHOD__.'插入数据库');
            /*=====  End of 进行增加的sql日志  ======*/

            if (!(is_numeric($pid) && is_numeric($djbh) && $pid > 20000 && $pid < 100000 && $djbh > 700 && $djbh < 1000000)) {
                Test::log(__METHOD__.'!!!取回的编码错误');

                throw new Exception('取回的编码错误'.__LINE__, 1);
            }
            Test::log(__METHOD__.'验证PID和DJBH合法性成功');

            $this->add_rizhi($pid, $djbh);

            /*=====  End of  进行日志增加   ======*/
            $this->deletefj($pid, $djbh);
        } else {
            throw new Exception('取回编码失败,没再进行日志插入和删除FJ'.__LINE__, 1);
        }
        Test::log(__METHOD__.'插入日志成功');

        return $response2;
    }

    /**
     * TODO:通过一条拨款数据返回指标DATA
     * - 传入@拨款数据
     * - 返回@指标DATA.
     */
    public function get_zbdata($zb_id)
    {
        Test::log(__METHOD__.'获取所有的授权指');
        $finddata = $this->Getsqzb->getsqdata();
        $collection = collect($finddata);
        $filtered = $collection->filter(function ($item) use ($zb_id) {
            return $item['ZBID'] == trim($zb_id);
        });
        Test::log(__METHOD__.'过滤指标');
        $zb = $filtered->pop();

        return $zb;
    }

    /**
     * TODO:[amount数据]对$this->insertbody 进行替换
     * - 传入@[amount数据]
     * - 返回@.
     */
    public function amountreplace($zbamount)
    {
        $pattern3 = '/\d{1,}(\.[0-9]{1,})?,\s+\d{1,}(\.[0-9]{1,})?,\s+\d{1,}(\.[0-9]{1,})?,\s+\d{1,}(\.[0-9]{1,2})?/';//这里的\s+\d{1,}(.[0-9]{1,})?可以不改为0，但是在setamount里需要改为0
        $copydata = $this->insertbody;
        $this->setAmountData($zbamount);
        $this->insertbody = preg_replace_with_count($pattern3, $this->getAmountData(), $this->insertbody,1);
        $this->checkreplace($copydata, $this->insertbody);
    }

    /**
     * TODO: 进行账户信息，摘要信息替换
     * - 传入@一条拨款数据
     * - 返回@.
     */
    public function accountreplace($payee)
    {
        $this->insertbody = $this->jiema($this->insertbody);
        $this->insertbody = iconv('GB2312', 'UTF-8', $this->insertbody);

        $search = [
            'zhaiyao'                 =>    $payee['zhaiyao'],
            '王纯'                    =>    $payee['payee'],
            '6226820017800467554'     =>    $payee['payeeaccount'],
            '遂川农商银行'            =>    $payee['payeebanker'],
            '99990247'                =>    '',
            '叶涛'                    =>    $payee['payee'],
            '178190121002547948'      =>    $payee['payeeaccount'],
            '遂川县农商合作银行'      =>    $payee['payeebanker'],
            '99991392'                =>    '',
            '99991797'                =>    '',
            '遂川县财政局枚江乡财政所'=>    '遂川县枚江镇财政所',
            '遂川县枚江镇财政所2'     =>    '遂川县枚江镇财政所',

        ];

        $this->insertbody = strtr($this->insertbody, $search);
        
        $this->insertbody = iconv('UTF-8', 'GB2312', $this->insertbody);
    }


    /**
     * TODO: 更新数据库的授权指标
     * - 传入@
     * - 返回@.
     */
    public function updatedb()
    {
        $finddata = $this->Getsqzb->getsqdata();
        $collection = collect($finddata);
        $collection = $collection->filter(function($value){
            return $value != null;
        })->map(function ($item) {
            $info = Guzzledb::updateOrCreate(['ZBID' => $item['ZBID']], $item);
            return $info;
        });

        return $collection;
    }

    /**
     * 插入日志.
     *
     * @param pid djbh
     *
     * @return ture
     */
    public function add_rizhi($pid, $djbh)
    {
        $data = $this->jiema($this->RZ_data);
        Test::log(__METHOD__.'解码日志sql');

        $timepattern = "/\'\s*20[123]([0-9]{5})\s*\'/";
        $copydata = $data;
        $data = preg_replace_with_count($timepattern, "to_char(sysdate,'yyyymmdd')", $data, 1);
        $this->checkreplace($copydata, $data);
        Test::log(__METHOD__.'替换日期');
        $pattern = "/\[001,.+\]/";
        $Y = (string) (date('Y'));
        $Ym = (string) (date('Ym'));
        $data2 = "[001,$Y,$Ym,$pid]";
        $copydata = $data;
        $this->setRizhiData($data2);
        $data = preg_replace_with_count($pattern, $this->getRizhiData(), $data, 1);
        $this->checkreplace($copydata, $data);
        Test::log(__METHOD__.'替换日志信息[]');
        $ifsuccess = $this->http->makerequest($data);
        if (!stristr($ifsuccess, 'NEWNO')) {
            //dd($ifsuccess);
            Test::log(__METHOD__.'!!!插入日志失败');

            throw new Exception('插入日志失败，可能是因为pid错误'.__LINE__, 1);
        }
        Test::log(__METHOD__.'插入日志成功');
        \App\Model\Sql::create(['pid'=>$pid, 'type'=>'addrizhi', 'djbh'=>$djbh, 'sql'=>iconv('GB2312', 'UTF-8', $data)]);
        Test::log(__METHOD__.'插入日志sql');

        return true;
    }

    /**
     * 删除附件.
     *
     * @param $pid,$djbh
     *
     * @author
     */
    public function deletefj($pid, $djbh)
    {
        $data = $this->jiema($this->FJ_data);
        $copydata = $data;
        $data = $this->timereplace($data,1,1,0);
        $this->checkreplace($copydata, $data);
        $copydata = $data;
        $data = str_replace('21886', $pid, $data);
        $this->checkreplace($copydata, $data);
        Test::log(__METHOD__.'解码、更换时间和pid');
        $ifsuccess = $this->http->makerequest($data);
        if (!stristr($ifsuccess, 'ZB_ZFPZFJ')) {
            //dd("$ifsuccess");
            Test::log(__METHOD__.'!!!插入日志失败');

            throw new Exception('删除附件失败，可能是因为pid错误'.__LINE__, 1);
        }
        \App\Model\Sql::create(['pid'=>$pid, 'type'=>'deletefj', 'djbh'=>$djbh, 'sql'=>iconv('GB2312', 'UTF-8', $data)]);

        return true;
    }

    /**
     * 进行数据库存档.
     *
     * @return void
     *
     * @author
     */
    public function savesql($data)
    {
        $res = Payout::create($data);
    }
}
