<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\ZbRepository;
use App\Repositories\ZfpzRepository;
use Carbon\Carbon;

class SearchDpt extends Command
{
    private $repository_zb;
    private $repository_zfpz;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:dpt {days?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '显示某日的收支表';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ZfpzRepository $repository_zfpz,
                                ZbRepository $repository_zb)
    {
        $this->repository_zfpz = $repository_zfpz;
        $this->repository_zb = $repository_zb;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $headers = ['LR_RQ', 'ZY', 'JE'];
        $date = $this->argument('days')?
        str_replace('-', '', Carbon::parse("-{$this->argument('days')} days")->toDateString()):
        date("Ymd");
        $table = $this->repository_zb->findwhere([['LR_RQ','>=',$date]],$headers)->map(
            function($val){
                return [$val->LR_RQ,$val->ZY,$val->JE];
            })->toArray();
        //dd($table);

        $this->info($date.'下达的收入指标');
        $this->table($headers, $table);

        $headers = ['QS_RQ', 'ZY', 'JE','SKR'];
        $table = $this->repository_zfpz->findwhere([['QS_RQ','>=',$date]],$headers)->map(
            function($val){
                return [$val->QS_RQ,$val->ZY,$val->JE,$val->SKR];
            })->toArray();
        $this->table($headers, $table);

    }
}
