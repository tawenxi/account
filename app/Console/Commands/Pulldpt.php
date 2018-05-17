<?php

namespace App\Console\Commands;

use Cache;
use Illuminate\Console\Command;
use App\Jobs\PullSQ;
use App\Jobs\PullZfpz;
use Illuminate\Support\Facades\Redis;
use App\Model\Respostory\Guzzle;
use App\Model\Respostory\Http;
use App\Model\Respostory\Getsqzb;
use App\Model\Respostory\GetSqlResult;
use App\Model\Tt\Data;
use App\Events\UpdateData;
use App\Model\Zfpz;
use App\Model\ZB;
use App\Model\ZJzb;

class Pulldpt extends Command
{
    use Data;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull:dpt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新数据';

    protected $pullsq;

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public $guzzle;
    public $getdetail;
    public $newpass = [];
    public $newzb = [];
    public $newsh = [];

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
        $this->PullZfpz();
        $this->cast();
        $this->Pullsq();
        $this->pullzjzb();
        $this->update_yeamount();
        $this->info('现在的session是'.session('ND'));
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
            $newzb = \App\Model\Zb::where('ZBID',$item['ZBID'])->first();

            if (!$newzb) {
                $this->newzb[] = $item['ZBID'];
            }
            \App\Model\Zb::updateOrCreate(['ZBID' => $item['ZBID']], $item);
        });

        $month = '01';
        if (\Carbon\carbon::now()->month>5) {
            $month = \Carbon\carbon::now()->month-1;
            $month = ($month<10)?'0'.(string)$month:(string)$month;
        }
        
        $zfpzdatas = $this->getdetail->getdata($this->zfpz, [
            ["'".config('app.MYND')."0101'", "'".config('app.MYND').$month."01'"], //每年修改
            ["'".config('app.MYND')."0821'", "to_char(sysdate,'yyyymmdd')"],
        ]);

        if ($zfpzdatas[0] === null) return true;
        foreach ($zfpzdatas as $zfpzdata) {
            if (!isset($zfpzdata['MXZBWH'])) {
                $zfpzdata['MXZBWH'] = '';
            }

            $qs = Zfpz::where('PDH',$zfpzdata['PDH'])->value('QS_RQ');

            if (!($qs) AND isset($zfpzdata['QS_RQ'])?$zfpzdata['QS_RQ']:false) {

                $this->newpass[] = $zfpzdata['PDH'];
            }

            $sh = Zfpz::where('PDH',$zfpzdata['PDH'])->value('SH_RQ');

            if (!($sh) AND isset($zfpzdata['SH_RQ'])?$zfpzdata['SH_RQ']:false) {

                $this->newsh[] = $zfpzdata['PDH'];
            }

            if (isset($zfpzdata['SH_RQ'])) {

                if ($zfpzdata['SH_RQ'] == '_') {

                $zfpzdata['SH_RQ'] = NULL;
                }
                
            }

            Zfpz::updateOrCreate(['PDH' => $zfpzdata['PDH']], $zfpzdata);
        }
        $PDH_count1 = Zfpz::all()->pluck(['PDH'])->unique()->count();
        $PDH_count2 = Zfpz::all()->pluck(['PDH'])->count();
        if ($PDH_count1 != $PDH_count2) dd('PDH重复');
        Zfpz::where(['received'=>1,'qs'=>0])->whereNotIn('PDH',collect($zfpzdatas)->pluck(['PDH'])->toArray())->update(['deleted'=>1]);
        $this->info('SUCCESS-更新收支指标成功');          
    }

    public function cast()
    {
        $zbs = [];$datas1 = [];$datas2 = [];
        if ($this->newpass != []) {
            $datas1 = zfpz::whereIn('PDH',$this->newpass)->get()->toarray();
            foreach ($datas1 as $data) {
                $data['LX'] = '已清算';
                // Redis::publish('test-channel',json_encode($data));
                event(new UpdateData($data));
            }
        }

        if ($this->newzb != []) {
            $zbs = ZB::whereIn('ZBID',$this->newzb)->get()->toarray();
            foreach ($zbs as $data) {
                $data['LX'] = '收到新指标';
                Redis::publish('test-channel',json_encode($data));
            }
        }

        if ($this->newsh != []) {
            $datas2 = zfpz::whereIn('PDH',$this->newsh)->get()->toarray();
            foreach ($datas2 as $data) {
                $data['LX'] = '已审核';
                // Redis::publish('test-channel',json_encode($data));
                event(new UpdateData($data));
            }
        }
        $save_zfpzs = array_merge($datas2,$datas1);

        $zbs = Cache::get('updatedZb')?array_merge($zbs,Cache::get('updatedZb')):$zbs;
        $save_zfpzs = Cache::get('updatedZfpz')?array_merge($save_zfpzs,Cache::get('updatedZfpz')):$save_zfpzs;


        Cache::put('updatedZb', $zbs, 600);
        Cache::put('updatedZfpz', $save_zfpzs, 600);
    }


    public function pullSQ()
    {  
        $this->guzzle->updatedb();
        $this->info('SUCCESS-更新授权指标成功');     
    }

    public function update_yeamount()
    {
        \App\Model\Zb::all()->each(function($val){
            \App\Model\Zb::where('ZBID',$val['ZBID'])->update(['yeamount'=>($val['JE']-$val->zfpzs->sum('JE'))*100]);
        });
        $this->info('SUCCESS-更新指标余额成功');     
    }




    public function pullzjzb()
    {
        $zjzbs = $this->getdetail->getdata($this->zhijie_zhifu_data, [
            ["'".config('app.MYND')."0408'", "to_char(sysdate,'yyyymmdd')"],
        ]);

        if ($zjzbs[0] === null) return true;

        foreach ($zjzbs as $zjzb) {
            Zjzb::updateOrCreate(['ZBID' => $zjzb['ZBID'],
                                  'ZCLXDM'=>$zjzb['ZCLXDM'],
                                  'ZY'=>$zjzb['ZY'],
                                  'ZFFSDM'=>$zjzb['ZFFSDM'],
                                  'YSDWDM'=>$zjzb['YSDWDM'],
                                  'ZBLYDM'=>$zjzb['ZBLYDM'],
                                 ],$zjzb);
        }
        $this->info('SUCCESS-更新直接指标余额成功');     
    }
}
