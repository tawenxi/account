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
        //dd('切换到MS分支进行备份');
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
                //$this->onebyoneupdate();//为了安全暂不启用
                $this->info('已经还原成功');

                return true;
                break;

            case 'nobackup':
                $YES = $this->ask('是否不备份直接进行数据上传？回复<YES>继续');
                if ($YES === 'YES') {
                $password = $this->ask('请输入密码');
                if ($password === '6323151') {
                    $this->insertToMS();
                } else {
                    dd('密码错误');
                }

                return true;
                
            }
                $this->info('操作终止');

                return true;
                break;

            default:
                $this->backup();
                break;
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
      DB::connection('mysql')->table($table)->chunk(200,function($datas){
        foreach ($datas as $data) {
          DB::connection('sqlsrv')->table($table)->insert(get_object_vars($data));
        }
      });
    }

    /**
     * tranfor [object] to array
     *  Array.
     */
    public function transarray($arrays, $table)
    {
        $arrays = array_map('get_object_vars', $arrays);
        $arrays = collect($arrays)->map(function ($item, $key) use ($table) {

            switch ($table) {
              case 'lists':
                  $new_array = array_except($item, ['id']);
                break;
              case 'fenlus':
                  $new_array = array_except($item, ['id', 'list_id']);
                break;
              
              default:
                $new_array = $item;
                break;
            }

            return $new_array;
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
                  //校验拿到的null 转化成单空格
                    foreach ($val as $key => $value) {
                      if ($value == null) {
                          $val[$key] = ' ';
                      }  
                     }
                    DB::connection('sqlsrv')->table('GL_Pznr')->insert($val);
                });
            } else {
                dd();
            }

            $this->info('success-'.$table);
        }
    }
}
