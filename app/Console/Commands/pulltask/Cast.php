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

class Cast extends Command
{
    use Data;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull:cast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新监控数据';

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
        $this->cast();
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
        $this->info('实时监控成功');
    }
}
