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
    protected $signature = 'update:R9 {backup?}';

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
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //先进行数据备份,将GL_Pznr和GL_Pzml的数据做iseed备份，生成iseed文件
        //只要再运行db:seed就可以把备份文件插入本地的homestead数据表
        //如果不想进行备份可以update:R9 nobackup
        if ($this->argument('backup')!='nobackup' AND 
            $this->argument('backup')!='allrollback' ) {
            $this->call('iseed', [
            'tables' => 'GL_Pznr,GL_Pzml', 
            '--database' => 'sqlsrv',
            '--force' => 'true',
            ]); 
        }


        if ($this->argument('backup')=='allrollback') {
            $this->onebyoneupdate();
        }


        foreach ($this->tables as $table) {
            $arrays = DB::connection('mysql')->table($table)->get()->toarray();
            $arrays = $this->transarray($arrays,$table);

            if ($table == 'lists') {
                collect($arrays)->each(function($val){
                   DB::connection('sqlsrv')->table('GL_Pzml')->insert($val);
                });
    
            } elseif ($table == 'fenlus') {
                collect($arrays)->each(function($val){
                    DB::connection('sqlsrv')->table('GL_Pznr')->insert($val);
                });
            } else {
                dd();
            }

            $this->info('success-'.$table);
        }
        
    }

    /**
     *
     * all table need to update
     *
     */
    public $tables = ['lists','fenlus'];

    private $onebyonetables = ['GL_Pznr','GL_Pznr'];


    /**
     *
     * insert the msssql one by one with GL_
     *
     */
    public function onebyoneupdate() {
        foreach ($this->onebyonetables as $table) {
            $arrays = DB::connection('mysql')->table($table)
                      ->get()->toarray();
            $arrays = $this->transarray($arrays,$table);

            foreach (collect($arrays)->chunk(500) as $datas) {
                collect($arrays)->each(function($val) use ($table){
                    DB::connection('sqlsrv')->table($table)->insert($val);
                });
            }
        }
    }


/**
 *
 * tranfor [object] to array
 *  Array
 * 
 *
 */

    public function transarray($arrays,$table) {

        $arrays = array_map('get_object_vars', $arrays);
        $arrays = collect($arrays)->map(function($item,$key) use ($table){
            $keys = ($table=='lists')?['id'=>1]:($table=='fenlus')?['id'=>1,'list_id'=>2]:NULL;

            return collect($item)->diffKeys($keys)->all();
        })->toArray();

        return $arrays;
        

    }
    
    
}
