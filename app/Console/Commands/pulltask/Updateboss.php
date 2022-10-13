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


class Updateboss extends Command
{
    use Data;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pull:updateboss';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '更新boss数据';

    protected $pullsq;
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
        $this->update_boss();
    }

    public function update_boss()
    {
        $supportPoorer = \App\Model\Zfpz::withoutGlobalScopes()->where('YSDWDM','901012013')->get()->pluck('SKR')->unique();
        $bosses = \App\Model\Zfpz::withoutGlobalScopes()->get()->groupBy('SKR')
            ->sortByDesc(function($qq){
                return $qq->sum('JE');
                })->map(function($item,$key) use ($supportPoorer){
                    return ['name'=>$key,
                            'bank'=>$item->last()->SKRKHYH,
                            'bankaccount'=>$item->last()->SKZH,
                            'totalpayout'=>$item->sum('JE'),
                            'payoutcount'=>$item->count(),
                            'supportpoor'=>$supportPoorer->contains($key)?1:0
                           ];

                })->values()->each(function($item){
                    Boss::updateOrCreate(
                       ['name' => $item['name']],$item
                    );
                });
        $this->info('SUCCESS-更新收款人信息成功');
    }
}
