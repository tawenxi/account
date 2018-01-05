<?php

namespace App\Console\Commands;

use App\Model\Respostory\Guzzle;
use Illuminate\Console\Command;

class PullShujuyuan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull:shujuyuan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新拉取数据源';

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
        $qq->filter(function($item){
            return trim($item->body)=='' OR $item->body ===null;
        })->each(function($item){
            $body = $item->generateMybody()->encodeMybody();
            if (strstr(decode($body), '~')) {
                throw new Exception('数据源包含~');
            }
            $item->update(['body'=>$body]);  
        });

        $this->info('SUCCESS-更新数据源成功');
    }
}
