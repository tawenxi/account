<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

class UpdateWaiwang extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:imiguo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'update the imiguo';

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
        foreach ($this->tables as $table) {
            $arrays = DB::connection('mysql')->table($table)->get()->toarray();

            $arrays = array_map('get_object_vars', $arrays);

            if ($table == 'guzzledbs') {
                foreach ($arrays as $key => $value) {
                $arrays[$key]['body'] = $arrays[$key]['body']?:'';
                }
            }
            
            DB::transaction(function () use ($table,$arrays) {
                DB::connection('imiguo')->table($table)->truncate();
                $this->info('已经清空数据表'.$table);
                
                collect($arrays)->chunk(500)->each(function($data)use($table){
                    DB::connection('imiguo')->table($table)->insert($data->toarray());
                });
                
                $this->info('success-'.$table);

            });
        }
    }

    /**
     * all table need to update.
     */
    public $tables = ['guzzledbs', 'zbs', 'zfpzs', 'salaries', 'accounts'];
}
