<?php

namespace App\Console\Commands;

use App\Model\Zb;
use Illuminate\Console\Command;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:prezbid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'testcommand';

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
        session(['ND'=>'2018']);

        Zb::withoutGlobalScopes()->get()->each(function($item){
            $prezbid = ZB::withoutGlobalScopes()->where('ZY', $item->ZY)->where('Yeamount', $item->JE*100)->where('KJND',$item->KJND-1)->value('ZBID');
            $item->update(['prezbid'=>$prezbid]);
        });
        $this->info('更新来源指标数据成功');
    }
}
