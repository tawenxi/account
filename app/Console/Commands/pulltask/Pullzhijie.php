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

class Pullzhijie extends Command
{
    use Data;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull:zj';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新直接指标数据';

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
        $this->pullzjzb();
    }

    public function pullzjzb()
    {
        $zjzbs = $this->getdetail->getdata($this->zhijie_zhifu_data(), [
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
