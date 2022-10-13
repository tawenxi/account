<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Model\Respostory\Getsqzb;
use App\Model\Respostory\Guzzle;
use App\Model\Respostory\Http;



class PullSQ implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //private $guzzle;
    /**
     * Create a new job instance.
     *
     * @return void
     */ 
    public function __construct()
    {
        
       
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Guzzle $guzzle)
    {  
        $guzzle->updatedb();
        info('SUCCESS-更新授权指标成功');     
    }
}
