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
    protected $signature = 'pull:data';

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
        $this->call('pull:shujuyuan');
        $this->call('test:compare');

        $this->PullShenqing();
        $this->PullZfpz();
        $this->Pullsq();
        $this->update_yeamount();

        
    }


    public function PullZfpz()
    {
        Zfpz::where('QS_RQ','')->ORwhere('QS_RQ',NULL)->delete();
        $zb_data = $this->guzzle->get_ZB();
        $collection = collect($zb_data);
        $collection = $collection->reject(function($item,$key){
            return !array_key_exists('SHR', $item);
        })->map(function ($item) {
            if ($item["YWLXDM"] !="_" OR $item["XMFLDM"] !="_") 
                dd("发现YWLXDM，XMFLDM异常会影响数据源".$item["YWLXDM"].$item["XMFLDM"] !="_");
            \App\Model\Zb::updateOrCreate(['ZBID' => $item['ZBID']], $item);
        });

        

        $zfpzdatas = $this->getdetail->getdata($this->zfpz, [
            ["'20170101'", "'20170801'"], //每年修改
            ["'20170821'", "to_char(sysdate,'yyyymmdd')"],
        ]);

        foreach ($zfpzdatas as $zfpzdata) {
            if (!isset($zfpzdata['MXZBWH'])) {
                $zfpzdata['MXZBWH'] = '';
            }
            Zfpz::updateOrCreate(['PDH' => $zfpzdata['PDH']], $zfpzdata);
        }
        $this->info('SUCCESS-更新收支指标成功');          
    }


    /**
     *
     * 更新查询用款计划
     *
     */
    public function PullShenqing()
    {
        $YSDWDMS = ['901006000','901006001','901006013','901006010'];
        $date = '20'.date('ymd');
        $year = '20'.date('y');
        $data = [];

        \DB::table('zb_applies')->truncate();
        foreach ($YSDWDMS as $YSDW) 
        {
            $once_data = $this->getdetail->getdata($this->shenqingsql, [
                ["20171207", "{$date}"],
                ["'2017'", "'{$year}'"],
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
