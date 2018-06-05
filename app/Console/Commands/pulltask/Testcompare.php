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


class Testcompare extends Command
{
    use Data;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull:testcompare';

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
        $this->testCompare();
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
 
}
