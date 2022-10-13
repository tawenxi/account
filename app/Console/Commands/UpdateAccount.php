<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Account;

class UpdateAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the account data';

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
        //$this->Beuseful();
        $this->addaccount();
    }

    public function Beuseful()
    {
     $accounts = Account::all();
        $accounts->each(function($account) {
            $exisit = Account::where('account_number','like',$account->account_number.'%')->where('account_number','!=',$account->account_number)->exists();
            if ($exisit) {
                $account->update(['isuseful'=>0]);
            } else {
                //dd(1111);
                $account->update(['isuseful'=>1]);
            }
        });

        $this->info('update success');   
    }

    public function addaccount()
    {
        $accounts = \DB::connection('sqlsrv')->table('GL_Kmxx')->where('Jl_RQ','>','20180718')->get();

        foreach ($accounts as $account) {
            $this->info($account->kmdm.'---'.$account->kmmc.'---'.$account->Jl_RQ);
            
        }

        $accounts->each(function($val,$key){
            if(!Account::where('account_number',$val->kmdm)->exists()){
                Account::create(['account_number'=>$val->kmdm,
                                 'account_name'=>$val->kmmc,
                                 'name'=>$val->kmdm.'@'.$val->kmdm]);
                $this->info($val->kmdm.'==='.$val->kmmc.'==='.$val->Jl_RQ.'增加成功');
            }
            
        });
        
    }
}
