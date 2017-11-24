<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

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
     *
     * backupdata  from R9 to homestead (GL_Pznl and GL_Pzml)
     *
     */

    public function backup()
    {
        $process = $this->ask('这个操作会覆盖seed数据，请问您是否已经把seed文件备份在R9Database，回答YES进行备份?');
        if ($process != 'YES') {
            dd('操作终止');
        }
        $this->call('iseed', [
            'tables' => 'GL_Pznr,GL_Pzml', 
            '--database' => 'sqlsrv',
            '--force' => 'true',
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
        //如果不想进行备份可以update:R9 --only=nobackup

        //在 MS分支下 只能进行 php artisan update:R9 --only=backup 和
                //             php artisan db:seed 操作
        switch ($this->option('only')) {
            case 'backup':
                $this->backup();
                return true;
                break;
        }
    }

    /**
     *
     * all table need to update
     *
     */
    public $tables = ['lists','fenlus'];

    private $onebyonetables = ['GL_Pznr','GL_Pznr'];
}
