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
    protected $signature = 'test:compare {year?}';

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
        $Guzzledb = \App\Model\Guzzledb::all();
        $Guzzledb->reject(function($item){
            return trim($item->body)=='';
        })->each(function($item){
            $res = $item->comparebody();
            if ($res) {
               $this->info($item->id);
            } else {
                $this->info('*******');
                //throw new \Exception('验证数据源失败'.$item->id.'号失败');
            }
        });
        $this->info('SUCCESS-验证'.$this->argument('year').'年数据源成功');
    }
}
