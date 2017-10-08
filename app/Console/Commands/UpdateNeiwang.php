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
    protected $signature = 'update:R9';

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
        //先进行数据备份
        $this->call('iseed', [
        'tables' => 'GL_Pznr,GL_Pzml', 
        '--database' => 'sqlsrv',
        '--force' => 'true'
        ]);

        foreach ($this->tables as $table) {
            $arrays = DB::connection('mysql')->table($table)->get()->toarray();

            $arrays = array_map('get_object_vars', $arrays);
            
            $arrays = collect($arrays)->map(function($item,$key) use ($table){
                $keys = ($table=='lists')?['id'=>1]:($table=='fenlus')?['id'=>1,'list_id'=>2]:NULL;
                if (!$keys) {
                    dd('错误',$table);
                }
                return collect($item)->diffKeys($keys)->all();
            })->toArray();


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


    /**
     *
     * insert the msssql one by one with GL_
     *
     */

    public function onebyoneupdate() {
        

    }
    
}
