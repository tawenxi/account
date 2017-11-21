<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class UpdateNeiwang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:R9 {--only=defalte}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update the R9,先备份本地的2个重要数据，再进行插入Rq操作';

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
     * backupdata  from R9 to homestead (GL_Pznl and GL_Pzml).
     */
    public function backup()
    {
        $this->ask('这个操作会覆盖seed数据，请问您是否已经把seed文件备份在R9Database，回答YES进行备份?,如果没有commit备份请切换到MSSQLDATABASE分支');
        $this->call('iseed', [
            'tables'     => 'GL_Pznr,GL_Pzml',
            '--database' => 'sqlsrv',
            '--force'    => 'true',
        ]);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //先进行数据备份,将GL_Pznr和GL_Pzml的数据做iseed备份，生成iseed文件
        //只要再运行db:seed就可以把备份文件插入本地的homestead数据表
        //如果不想进行备份可以update:R9 nobackup
        switch ($this->option('only')) {
            case 'backup':
                $this->backup();
                $this->info('已经备份完成');

                return true;
                break;

            case 'allrollback':
                $this->onebyoneupdate();
                $this->info('已经还原成功');

                return true;
                break;

            case 'nobackup':
            $YES = $this->ask('是否不备份直接进行数据上传？回复<YES>继续');
            if ($YES == 'YES') {
                break;
            }
                $this->info('操作终止');

                return true;

            default:
                $this->backup();
                break;
        }

        $password = $this->ask('请输入密码');
        if ($password == '6323151') {
            $this->insertToMS();
        } else {
            dd('密码错误');
        }

        
    }

    /**
     * all table need to update.
     */
    public $tables = ['lists', 'fenlus'];

    private $onebyonetables = ['GL_Pznr', 'GL_Pznr'];

    /**
     * insert the msssql one by one with GL_.
     */
    public function onebyoneupdate()
    {
        foreach ($this->onebyonetables as $table) {
            $arrays = DB::connection('mysql')->table($table)
                      ->get()->toarray();
            $arrays = $this->transarray($arrays, $table);

            foreach (collect($arrays)->chunk(500) as $datas) {
                collect($arrays)->each(function ($val) use ($table) {
                    DB::connection('sqlsrv')->table($table)->insert($val);
                });
            }
        }
    }

    /**
     * tranfor [object] to array
     *  Array.
     */
    public function transarray($arrays, $table)
    {
        $arrays = array_map('get_object_vars', $arrays);
        $arrays = collect($arrays)->map(function ($item, $key) use ($table) {
            $keys = ($table == 'lists') ? ['id'=>1] : ($table == 'fenlus') ? ['id'=>1, 'list_id'=>2] : null;

            return collect($item)->diffKeys($keys)->all();
        })->toArray();

        return $arrays;
    }

    public function insertToMS()
    {
        foreach ($this->tables as $table) {
            $arrays = DB::connection('mysql')->table($table)->get()->toarray();
            $arrays = $this->transarray($arrays, $table);

            if ($table == 'lists') {
                collect($arrays)->each(function ($val) {
                    DB::connection('sqlsrv')->table('GL_Pzml')->insert($val);
                });
            } elseif ($table == 'fenlus') {
                collect($arrays)->each(function ($val) {
                    DB::connection('sqlsrv')->table('GL_Pznr')->insert($val);
                });
            } else {
                dd();
            }

            $this->info('success-'.$table);
        }
    }
}
