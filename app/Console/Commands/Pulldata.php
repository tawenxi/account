<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\PullSQ;
use App\Jobs\PullZfpz;
use App\Model\Respostory\Guzzle;
use App\Model\Respostory\Http;
use App\Model\Respostory\Getsqzb;
use App\Model\Respostory\GetSqlResult;
use App\Model\Tt\Data;
use App\Model\Zfpz;


class Pulldata extends Command
{
    use Data;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull:data {sq?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新数据（dpt和ZFPZ）';

    protected $pullsq;

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public $guzzle;
    public $getdetail;



    public function __construct(Guzzle $guzzle,GetSqlResult $getdetail)
    {
        $this->guzzle = $guzzle;
        $this->getdetail = $getdetail;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //PullSQ::dispatch();
        //PullZfpz::dispatch();
        //dd(session('ND'));
        //$this->info('现在的session是'.session('ND'));
        if ($this->argument('sq') == 'shenqin') {
        	$this->PullShenqing();
        }
        //$this->testCompare();
        
        $this->PullZfpz();
        $this->Pullsq();
  
        $this->update_yeamount();

        $this->info('现在的session是'.session('ND'));
    }

    public function testCompare()
    {
        $session = session('ND');
        session(['ND'=>(string)((int)config('app.MYND')-1)]);
        $this->call('pull:shujuyuan');
        $this->call('test:compare',['year'=>session('ND')]);
        dd(1);
        session(['ND'=>config('app.MYND')]);
        $this->call('pull:shujuyuan');
        $this->call('test:compare',['year'=>session('ND')]);
        session(['ND'=>$session]);
    }


    public function PullZfpz()
    {
        session(['ND'=>'2018']);
        \DB::table('zfpzs')->where('QS_RQ','!=',NULL)->update(['qs'=>1]);
        Zfpz::where(['QS_RQ'=>NULL,'received'=>'0'])->delete();
        $zb_data = $this->guzzle->get_ZB();
        $collection = collect($zb_data);
        $collection = $collection->reject(function($item,$key){
            return !array_key_exists('SHR', $item);
        })->map(function ($item) {
            //dd($item["SJWH"]);
            if ($item["YWLXDM"] !="_" OR
                $item["XMFLDM"] !="_" ) 
                dd("发现YWLXDM，XMFLDM异常会影响数据源".$item["YWLXDM"].$item["XMFLDM"] !="_");
            if (isset($item["SJWH"]) AND $item["SJWH"] !=="" AND $item["SJWH"] !="_") {
                dd("发现SJWH异常会影响数据源");
            }
            \App\Model\Zb::updateOrCreate(['ZBID' => $item['ZBID']], $item);
        });

  

        $zfpzdatas = $this->getdetail->getdata($this->zfpz, [
            ["'".config('app.MYND')."0101'", "'".config('app.MYND')."0101'"], //每年修改
            ["'".config('app.MYND')."0821'", "to_char(sysdate,'yyyymmdd')"],
        ]);

        if ($zfpzdatas[0] === null) return true;
        foreach ($zfpzdatas as $zfpzdata) {
            if (!isset($zfpzdata['MXZBWH'])) {
                $zfpzdata['MXZBWH'] = '';
            }
            Zfpz::updateOrCreate(['PDH' => $zfpzdata['PDH']], $zfpzdata);
        }
        $PDH_count1 = Zfpz::all()->pluck(['PDH'])->unique()->count();
        $PDH_count2 = Zfpz::all()->pluck(['PDH'])->count();
        if ($PDH_count1 != $PDH_count2) dd('PDH重复');
        Zfpz::where(['received'=>1,'qs'=>0])->whereNotIn('PDH',collect($zfpzdatas)->pluck(['PDH'])->toArray())->update(['deleted'=>1]);
        $this->info('SUCCESS-更新收支指标成功');          
    }


    /**
     *
     * 更新查询用款计划
     *
     */
    public function PullShenqing()
    {
        $YSDWDMS = ['901012000','901012001','901012013','901012010'];
        $date = '20'.date('ymd');
        $year = '20'.date('y');
        $data = [];

        \DB::table('zb_applies')->truncate();
        foreach ($YSDWDMS as $YSDW) 
        {
            $once_data = $this->getdetail->getdata($this->shenqingsql, [
                [config('app.MYND')."1207", "{$date}"],
                ["'".config('app.MYND')."'", "'{$year}'"],
                ['901006001', $YSDW],
            ]);
            if (!in_array(null,$once_data)) $data = array_merge($once_data,$data);
        }

        if (!empty($data) AND !in_array(null,$data)) {
            
            \DB::table('zb_applies')->insert($data);   
        }
       
        $this->info('SUCCESS-更新支付申请指标成功');          
    }
    

    public function pullSQ()
    {  
        $this->guzzle->updatedb();
        $this->info('SUCCESS-更新授权指标成功');     
    }

/**
 *
 *   更新剩余金额
 *
 */

    public function update_yeamount()
    {
        \App\Model\Zb::all()->each(function($val){
            \App\Model\Zb::where('ZBID',$val['ZBID'])->update(['yeamount'=>($val['JE']-$val->zfpzs->sum('JE'))*100]);
        });
        $this->info('SUCCESS-更新指标余额成功');     
    }
}
