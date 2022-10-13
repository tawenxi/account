<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Auth;

class HelloConsole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'say:hello {xiangzhen?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        dd($this->argument('xiangzhen'));
        Auth::loginUsingId(39);
        dd(config('app.xiangzhen')[\Auth::user()->email]);
    }
}
