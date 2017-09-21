<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Rccount\Bill;
use App\Rccount\Fenlu;
use App\Rccount\Account;

class SearchAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:account {account} {--key=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'search:account';

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
        //$headers = ['kjqj','pzh','zy', 'jie','dai','je','kmdm'];

        $headers = ['kjqj','pzh','zy', 'jie','dai','kmdm','yue'];

        $accounts = Account::
        //where('zy', 'like',"%{$this->argument('account')}%")->
        Where('kmdm' ,$this->argument('account'))
        ->where('fzdm10','')
        ->get();

        Global $total;
        $total = \DB::table('accounts')->where('account_number',$this->argument('account'))->value('init');
        
        $table = $accounts->map(function($account) use ($headers,$total){
            
            $account['jie'] = round($account->jie,2);

            $account['dai'] = round($account->dai,2);
            $account['zy'] = trim(mb_substr($account['zy'],0,10,"utf-8"));
            //dd($account['jie']>0,$account['jie']);
            //dd($account['dai']>0,$account['dai']);
            $GLOBALS['total'] = round($GLOBALS['total'],2) + round((($account['jie']!=0)?$account['jie']:0),2) - round((($account['dai']!=0)?$account['dai']:0),2);
            $account['yue'] = round($GLOBALS['total'],2);
            return $account->only($headers);
        });


       

        $this->table($headers, $table);
    }
}
