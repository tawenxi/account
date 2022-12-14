<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InsertSalary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:salary {exc?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '注入工资';

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
        // Global $exce;
        // $exce = $this->argument('exc');
        cache(['excel'=>$this->argument('exc')], 10);
        $import = app()->make("\App\Model\SalaryListImport");
        $ziduan = ['member_id',
        'name', 'account', 'bumen',
        'yishu_bz', 'tuixiu_gz',
        'bufa_gz', 'nianzhong_jj',
        'gaowen_jiangwen', 'jiangjin',
        'jiangjin_beizhu',
        'jjbz', 'beuzhu',
        'gjj_dw', 'sb_dw',
        'gjj_gr', 'sb_gr',
        'zhiye_nj', 'daikou_gz',
        'fanghong_zj', 'yiliao_bx',
        'shiye_bx', 'shengyu_bx',
        'gongshang_bx',
        'yirijuan', 'tiaozheng_gjj',
        'tiaozheng_sb', 'date',
        'jb_gz1', 'jb_gz2',
        'jinbutie', 'gongche_bz',
        'xiangzhen_bz', 'sb_js',
        'gjj_js', 'other_daikou',
        'daikou_beizhu', ]; //34个字段
        $res = $import->skipRows(1)->setDateColumns([
            'created_at',
            'updated_at',
            'date',
        ])->get($ziduan);
        $res->map(function ($v) {
            static $i;
            $v['name'] = str_replace(' ', '', $v['name']);
            \App\Model\Salary::updateOrCreate([
            'member_id'      => $v['member_id'],
            'date'           => $v['date'],
            'jjbz'           => $v['jjbz'],
            'jiangjin_beizhu'=> $v['jiangjin_beizhu'],
            ], $v->toArray());
            $i++;
            $this->info("插入第{$i}条数据成功".'--'.$v['member_id'].$v['name']);
        });
    }
}
