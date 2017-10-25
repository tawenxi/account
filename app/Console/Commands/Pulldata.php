<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\PullSQ;
use App\Jobs\PullZfpz;
use App\Model\Respostory\Guzzle;
use App\Model\Respostory\Http;
use App\Model\Respostory\Getsqzb;

class Pulldata extends Command
{
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
    public function __construct()
    {
        
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        PullSQ::dispatch();
        PullZfpz::dispatch();
    }
}
