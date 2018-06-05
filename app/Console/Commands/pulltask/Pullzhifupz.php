<?php

namespace App\Console\Commands\pulltask;

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

class Pullzhifupz extends Command
{
    use Data;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull:zfpz';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新指标数据';

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
}
