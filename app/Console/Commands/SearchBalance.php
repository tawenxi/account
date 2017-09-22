<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Rccount\Bill;
use App\Rccount\Fenlu;
use App\Rccount\Account;
use App\Rccount\Robot;

class SearchBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:balance';

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
    public $robot;
    public function __construct(Robot $robot)
    {
        $this->robot = $robot;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $kemus = \App\Model\Account::all();
        $balance = $kemus->map(function($kemu){
            $balance = array();
            $balance['kmdm'] = $kemu->account_number;
            $balance['kmmc'] = $kemu->account_name;
            $yue = $this->robot->GetBalance($kemu->account_number);
            if ($yue > 0) {
                $balance['jdbz'] = '借';
            } elseif($yue < 0) {
                $balance['jdbz'] = '贷';
            } else {
                $balance['jdbz'] = '平';
            }
            $balance['balance'] =$yue;
            return $balance;
        })->toarray();
        $headers = ['kmdm','kmmc','jdbz','balance'];
        $this->table($headers, $balance);
    }
}
