<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Pulldpt extends Command
{
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
        $this->call('pull:zfpz');
        $this->call('pull:cast');
        $this->call('pull:sq');
        $this->call('pull:zj');
        $this->call('pull:yue');
    }
}
