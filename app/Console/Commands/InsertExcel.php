<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InsertExcel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:excel {excel?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '注入Excel';

    protected $excel;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(\App\Model\Respostory\Excel $excel)
    {
        parent::__construct();
        $this->excel = $excel;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $excel2 = $this->excel->setExcelFile($this->argument('excel'));
        $excel2->setSkipNum()->getExcel()->map(function ($v) {
            static $i;
            \DB::table($this->argument('excel').'s')->insert($v->toArray());
            $i++;
            $info = isset($v['zhaiyao']) ? $v['zhaiyao'] : $v['name'];
            $this->info("插入第{$i}条数据成功".'--'.$info.$v['amount']);
        });
    }
}
