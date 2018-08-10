<?php

namespace App\Console\Commands\pulltask;

use Illuminate\Console\Command;
use App\Jobs\PullSQ;
use App\Jobs\PullZfpz;
use App\Model\Respostory\Guzzle;
use App\Model\Respostory\Http;
use App\Model\Respostory\Getsqzb;
use App\Model\Respostory\GetSqlResult;
use App\Model\Tt\Data;
use App\Model\Zfpz;
use App\Model\Boss;


class Pullshenqing extends Command
{
    use Data;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull:shenqing';

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
        $this->PullShenqing();
    }



    public function PullShenqing()
    {
        $YSDWDMS = ['901012000','901012001','901012013','901012010'];
        $date = '20'.date('ymd');
        $year = '20'.date('y');
        $data = [];

        \DB::table('zb_applies')->truncate();
        foreach ($YSDWDMS as $YSDW) 
        {
            $once_data = $this->getdetail->getdata($this->shenqingsql(), [
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
    

}
