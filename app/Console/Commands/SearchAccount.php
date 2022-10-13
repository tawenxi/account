<?php

namespace App\Console\Commands;

use App\Rccount\Account;
use App\Rccount\Robot;
use Illuminate\Console\Command;

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
        //删除作废凭证数据
        // $zuofei_pzs = \DB::table('GL_Pzml')->where('zt','0')->get(['kjqj','pzh']);
        // foreach ($zuofei_pzs as $zuofei_pz) {
        //     \DB::table('GL_Pznr')->where('kjqj', $zuofei_pz->kjqj)->where('pzh', $zuofei_pz->pzh)->delete();
        // }

        $account_id = 0;
        if (!$this->argument('account')) {
            do {
                do {
                    $key = $this->ask('请输入科目关键字');
                    $topics =
                    \App\Model\Account::select(['id', 'name'])
                    ->where('name', 'like', '%'.$key.'%')->get();
                } while (empty($topics->first()));

                foreach ($topics as $key => $topic) {
                    $this->info($topic->id.'--'.$topic->name);
                }
                $YN = $this->ask('是否找到科目');
            } while ($YN !== 'y' and $YN !== 'q');
            do {
                $account_id = $this->ask('请选择科目id');
            } while (!in_array($account_id, $topics->pluck('id')->toArray()));
        }
        $account_number = $account_id ?
        (int) \App\Model\Account::where('id', $account_id)->value('account_number') :
        $this->argument('account');


        if (is_numeric($account_number)) {

            $this->info(\App\Model\Account::where('account_number', $account_number)->value('account_name'));
            $headers = ['kjqj', 'pzh', 'zy', 'jie', 'dai', 'kmdm', 'yue'];
            $accounts = Account::
            Where('kmdm', $account_number)
            ->where('fzdm10', '')
            ->get();

            global $total;
            $total = \DB::table('accounts')->where('account_number', $account_number)->value('init');
            
            $table = $accounts->map(function ($account) use ($headers,$total) {
                $account['jie'] = div($account->jie);
                $account['dai'] = div($account->dai);
                $account['zy'] = trim(mb_substr($account['zy'], 0, 8, 'utf-8'));
                $GLOBALS['total'] = div($GLOBALS['total']) + div((($account['jie'] != 0) ? $account['jie'] : 0)) - div((($account['dai'] != 0) ? $account['dai'] : 0));
                $account['yue'] = div($GLOBALS['total']);

                return $account->only($headers);
            });
            $this->table($headers, $table);

        } else {
             $this->search_zy($this->argument('account'));
        }
        

        //dd($this->robot->GetBalance('1001'));
    }



    /**
     *
     * 查询对象科目
     *
     */

    public function search_zy($key_word)
    {
        $headers = ['kjqj', 'pzh', 'zy','jdbz','je','kmdm'];
        $res = [];
        $table = \DB::table('GL_Pznr')->where('zy', 'like', "%$key_word%")
                    ->where('kmdm','!=','1002001')->get($headers)
                ->map(function($account) use ($res){
                    $res['kjqj'] = $account->kjqj;
                    $res['pzh'] = $account->pzh;
                    $res['zy'] = trim(mb_substr($account->zy, 0, 16, 'utf-8'));
                    $res['jdbz'] = $account->jdbz;
                    
                    $res['je'] = $account->je;
                    $res['kmdm'] = $account->kmdm;
                    $res['account_name'] = \DB::table('accounts')->where('account_number', $account->kmdm)->value('account_name');

                    return $res;
                });

        //dd($table);
                array_push($headers, '科目');
        $this->table($headers, $table);
    }
}
