<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Rccount\Bill;
use App\Rccount\Fenlu;
use App\Rccount\Account;
use App\Rccount\Robot;

class SearchAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:account {account?} {--key=*}';

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
        $account_id = 0;
        if (!$this->argument('account')) {

            do {
                do 
                {
                    $key = $this->ask('请输入科目关键字');
                    $topics = 
                    \App\Model\Account::select(['id','name'])
                    ->where('name','like','%'.$key.'%')->get();
                } while (empty($topics->first()));
                
                foreach ($topics as $key => $topic) 
                {
                    $this->info($topic->id.'--'.$topic->name);

                }
                $YN = $this->ask('是否找到科目');
            } while ($YN !== 'y' AND $YN !=='q');
            do 
            {
                $account_id = $this->ask('请选择科目id');
            } while (!in_array($account_id, $topics->pluck('id')->toArray()))  ;       
        }
        $account_number = $account_id?
        (int)\App\Model\Account::where('id',$account_id)->value('account_number'):
        $this->argument('account');
        $this->info(\App\Model\Account::where('account_number',$account_number)->value('account_name'));
        $headers = ['kjqj','pzh','zy', 'jie','dai','kmdm','yue'];
        $accounts = Account::
        Where('kmdm',$account_number)
        ->where('fzdm10','')
        ->get();

        Global $total;
        $total = \DB::table('accounts')->where('account_number',$account_number)->value('init');
        
        $table = $accounts->map(function($account) use ($headers,$total){   
            $account['jie'] = round($account->jie,2);
            $account['dai'] = round($account->dai,2);
            $account['zy'] = trim(mb_substr($account['zy'],0,10,"utf-8"));
            $GLOBALS['total'] = round($GLOBALS['total'],2) + round((($account['jie']!=0)?$account['jie']:0),2) - round((($account['dai']!=0)?$account['dai']:0),2);
            $account['yue'] = round($GLOBALS['total'],2);
            return $account->only($headers);
        });
        $this->table($headers, $table);

        //dd($this->robot->GetBalance('1001'));
    }
}
