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
        $this->PullZfpz();
        $this->Pullsq();
    }


    public function PullZfpz()
    {

        $zb_data = $this->guzzle->get_ZB();
        $collection = collect($zb_data);
        $collection = $collection->reject(function($item,$key){
            return !array_key_exists('SHR', $item);
        })->map(function ($item) {
            
            \App\Model\Zb::updateOrCreate(['ZBID' => $item['ZBID']], $item);
        });
        //更新剩余金额
        \App\Model\Zb::all()->each(function($val){
            \App\Model\Zb::where('ZBID',$val['ZBID'])->update(['yeamount'=>($val['JE']-$val->zfpzs->sum('JE'))*100]);
        });
        

        $zfpzdatas = $this->getdetail->getdata($this->zfpz, [
            ["'20170101'", "'20170801'"], //每年修改
            ["'20170821'", "to_char(sysdate,'yyyymmdd')"],
        ]);
        foreach ($zfpzdatas as $zfpzdata) {
            \App\Model\Zfpz::updateOrCreate(['PDH' => $zfpzdata['PDH']], $zfpzdata);
        }
        $this->info('SUCCESS-更新收支指标成功');          
    }

    public function pullSQ()
    {  
        $this->guzzle->updatedb();
        $this->info('SUCCESS-更新授权指标成功');     
    }
}
