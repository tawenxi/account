<?php

namespace App\Console\Commands;

use Schema;
use Illuminate\Console\Command;
use Illuminate\Database\Schema\Blueprint;
use Maatwebsite\Excel\Facades\Excel;

class Array2Sql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'array2sql {table?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'array to sql table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Excel $guzzleexcel)
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
        $tablename = $this->argument('table');
        if (Schema::hasTable($tablename)) {
            Schema::drop($tablename);
        }
        
        
        
        $data = Excel::load('/Users/entimmliu/sites/account/'.$tablename.'.csv', function($reader) {
            $results = $reader->get();
            $results = $reader->all();
        })->toarray();



        $header = collect($data[0])->keys();

        Schema::create($tablename, function(Blueprint $table) use ($header) {
            $table->increments('id');
            foreach ($header as $value) {
                $table->string($value);
            }
        });

        \DB::table($tablename)->insert($data);

        $this->info('success');
    }
}
