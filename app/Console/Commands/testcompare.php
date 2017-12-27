<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Testcompare extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:compare';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '测试数据源';

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
        $qq = \App\Model\Guzzledb::all();
        $qq->reject(function($item){
            return trim($item->body)=='';
        })->each(function($item){
            $res = $item->comparebody();
            if ($res) {
                $this->info($item->id);
            } else {
                $this->error($item->id);
            }
        });
        }
}
