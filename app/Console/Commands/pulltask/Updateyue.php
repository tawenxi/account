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

class updateyue extends Command
{
    use Data;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull:yue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新余额数据';

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
        $this->update_yeamount();
    }

    public function update_yeamount()
    {
        session(['ND'=>config('app.MYND')]);
        \App\Model\Zb::all()->each(function($val){
            \App\Model\Zb::where('ZBID',$val['ZBID'])->update(['yeamount'=>($val['JE']-$val->zfpzs->sum('JE'))*100]);
        });
        $this->info('SUCCESS-更新指标余额成功');     
    }
}
