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
        $this->setPreZbid();
        $this->setOriginZbid();
    }

    public function setOriginZbid()
    {
        $zbs = Zb::WithoutGlobalScopes()->get();
        $zbs->each(function($zb){
            $zb->update(['originzbid'=>$this->OriginZbid($zb->ZBID)]);
        });

        $this->info('更新源头指标ID成功！');
    }
    public function OriginZbid($zbid)
    {
          $zbid =Zb::WithoutGlobalScopes()->where('ZBID',$zbid)->first();
          if ( $zbid->prezbid() === false) {
              return  null;
          }
          while ($zbid = $zbid->prezbid()) {
              $originZb = $zbid;
          }
          if ($originZb) {
              return $originZb->ZBID;
          }
        return null;
    }

    public function setPreZbid()
    {
        session(['ND'=>config('app.MYND')]);

        Zb::withoutGlobalScopes()->get()->each(function($item){
            $prezbid = ZB::withoutGlobalScopes()->where('ZY', $item->ZY)->where('Yeamount', $item->JE*100)->where('KJND',$item->KJND-1)->value('ZBID');
            $item->update(['prezbid'=>$prezbid]);
        });
        $this->info('更新来源指标数据成功');
        session(['ND'=>config('app.MYND')]);
    }
}
