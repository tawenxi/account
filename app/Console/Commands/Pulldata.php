<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Pulldata extends Command
{
    protected $signature = 'pull:data {sq?}';
    protected $description = '更新数据（dpt和ZFPZ）';

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
        //PullSQ::dispatch();
        //PullZfpz::dispatch();
        //dd(session('ND'));
        //$this->info('现在的session是'.session('ND'));
        if ($this->argument('sq') == 'shenqin') {
        	$this->call('pull:shenqing');
        }

        $this->call('pull:updateboss');
        //$this->call('pull:testcompare');
        $this->call('pull:zfpz');
        $this->call('pull:sq');
        $this->call('pull:yue');
    }
}
