<?php

namespace App\Console\Commands;

use App\Model\Respostory\Excel;
use App\Rccount\Bill;
use App\Rccount\Fenlu;
use App\Rccount\Robot;
use Illuminate\Console\Command;

class InsertAccount extends Command
{
    private $fenlu;
    private $list;
    private $robot;
    private $excel;


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:account {del?}';  //输入2

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '注入 account to R9';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Excel $excel, Robot $robot)
    {
        parent::__construct();
        $this->excel = $excel;
        $this->robot = $robot;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->argument('del') == 1) {
            Bill::truncate();
            Fenlu::truncate();
            dd('清空表格');
        } elseif ($this->argument('del') == 2) {
            Bill::truncate();
            Fenlu::truncate();
            $this->info('正在清空表格...');
        }

        $fenlus = $this->excel->setExcelFile('fenlus')->getExcel();

        $fenlus->each(function ($v) {
            $fenlu = new Fenlu();
            $fenlu->kjqj = $v['kjqj'];
            $fenlu->pzh = (int)$v['list_id'];
            $fenlu->flh = $v['flh'];
            $fenlu->zy = $v['zy'];
            $fenlu->kmdm = $v['kmdm'];
            $fenlu->jdbz = $v['jdbz'];
            $fenlu->je = div($v['je']);
            $fenlu->wldrq = $v['wldrq'];
            $fenlu->xmdm = $v['xmdm'];
            $fenlu->list_id = (int)$v['list_id'];

            $ok = $fenlu->save();
            if (!$ok) {
                Bill::truncate();
                Fenlu::truncate();
                $this->info('分录数据有错，保存失败'.$v->zy.'--'.$v->je);
                dd('分录数据错误');
            }
        });
        $this->info('进行最后的一个分录调整');

        $check = $this->robot->checkbe_balance_and_insert_list(Fenlu::max('list_id'));

        if (!$check) {
            dd('借贷平衡失败');
        }

        $this->info('fenlu总金额-'.div($fenlus->sum('je')));
        $this->info('fenlu总数量-'.$fenlus->where('flh', 1)->count());
        $this->error('比对双方数据...:');

        $bills = Bill::get();
        $bills->each(function ($v) {
            $flh = $v->Fenlus->pluck('flh');
            $i = 0;
            while ($shift = $flh->shift()) {
                $check = ($shift == ++$i);
                if (!$check) {
                    dd('验证行号错误', $shift, $i);
                }
            }
            //$a = $v->Fenlus->count();
            //dd($t);
            if (div($v->pzje == $v->Fenlus->sum('je') / 2) &&
               div($v->Fenlus()->where('jdbz', '借')->sum('je')) ==
               div($v->Fenlus()->where('jdbz', '贷')->sum('je'))) {
                $this->info($v->pzh.'比对成功');
            } else {
                $this->error($v->pzh.'比对失败');
                $this->error($v->pzje);
                $this->error($v->Fenlus->sum('je'));
                dd();
            }
        });

        /**
         * 询问是否进行数据插入远程R9操作.
         */
        $YES = $this->ask('是否继续进行插入数据库操作？回复YES继续（1）备份数据');
        if ($YES === 'YES') {
            $this->call('update:R9', [
                '--only'=>'nobackup',
            ]);
        }
    }
}
