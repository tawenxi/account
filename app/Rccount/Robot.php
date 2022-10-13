<?php

namespace App\Rccount;

class Robot
{
    public function check_last_balance($list_id)
    {
        $jie = Fenlu::where('list_id', $list_id)
                    ->where('jdbz', '借')->sum('je');
        $dai = Fenlu::where('list_id', $list_id)
                    ->where('jdbz', '贷')->sum('je');


        //echo $jie."   ".$dai;
        if ($jie != $dai && $jie == 0) {
            return $this->be_balance('jie', $dai);
        } elseif ($jie != $dai && $dai == 0) {
            return $this->be_balance('dai', $jie);
        } elseif (div($jie) == div($dai)) {        
            return ['bool'=>true, 'amount'=>$jie, 'list_id'=>$list_id];
        } else {
            $wrong_id = $list_id;
            dd('平衡有错，多对多凭证号：'.$wrong_id.'金额'.$jie.'-'.$dai);
        }
    }



    /**
     *
     * @param $zero 传入：'jie',或者'dai' 表示借方或者贷方为0
     *        $amount 需要平衡的金额
     * 平衡分录
     *
     */


    public function be_balance($zero, $amount)
    {
        $last_fenlu = Fenlu::orderBy('list_id', 'desc')->first();
        $max_flh = Fenlu::where('list_id', $last_fenlu->list_id)->orderBy('list_id', 'desc')->max('flh');
        $new_fenlu = new Fenlu();
        $new_fenlu->kjqj = $last_fenlu->kjqj;
        $new_fenlu->pzh = $last_fenlu->list_id;
        $new_fenlu->flh = $max_flh + 1;
        $new_fenlu->zy = $last_fenlu->zy;
        $new_fenlu->kmdm = '1002001';
        $new_fenlu->jdbz = ($zero == 'jie') ? '借' : '贷';
        $new_fenlu->je = $amount;
        $new_fenlu->wldrq = $last_fenlu->wldrq;
        $new_fenlu->xmdm = '';
        $new_fenlu->list_id = $last_fenlu->list_id;
        $new_fenlu->save();
        //dd(Fenlu::all()->toarray());

        $jie = Fenlu::where('list_id', $last_fenlu->list_id) //list_id-1
                    ->where('jdbz', '借')->sum('je');
        $dai = Fenlu::where('list_id', $last_fenlu->list_id) //list_id-1
                    ->where('jdbz', '贷')->sum('je');

        if ($jie == $dai && $dai > 0) {
            return ['bool'=>true, 'amount'=>$jie, 'list_id'=>$last_fenlu->list_id];
        } else {
            dd($jie, $dai);
            dd('无法借贷平衡');
        }
    }

    public function checkbe_balance_and_insert_list($list_id){
        $check = $this->check_last_balance($list_id);

        if (!$check['bool']) {
                dd('借贷平衡失败');
            } else {        
                   return $this->insert_list($check);     
            }
    }

    public function insert_list($check)
    {   
        $list_info = [];
        $list_info['pzje'] = $check['amount'];
        $list_info['pzzy'] = Fenlu::where('list_id', $check['list_id'])
                                  ->where('flh', 1)
                                  ->value('zy');
        $list_info['srrq'] = Fenlu::where('list_id', $check['list_id'])
                                  ->where('flh', 1)
                                  ->value('wldrq');
        $list_info['pzrq'] = $list_info['srrq'];
        $list_info['kjqj'] = substr($list_info['srrq'], 0,6);
        $list_info['pzh'] = $check['list_id'];

        $bill = new Bill();
        $bill->kjqj = trim($list_info['kjqj']);
        $bill->pzh = (int)trim($list_info['pzh']);
        $bill->pzrq = trim($list_info['pzrq']);
        $bill->srrq = trim($list_info['srrq']);
        $bill->pzzy = trim($list_info['pzzy']);
        $bill->pzje = div(trim($list_info['pzje']));
        
        $ok = $bill->save();
        //dd($bill->toarray());
    
        if (!$ok) {
        Bill::truncate();
        Fenlu::truncate();
        dump('失败--'.$list_info['pzzy'].'--'.$list_info['pzje']);
        dd('list数据错误');
            
        }
        return true;
    }



    public function GetBalance($account_number)
    {
        $accounts = Account::Where('kmdm', $account_number)
        ->where('fzdm10', '')
        ->get();

        global $total;
        $total = \DB::table('accounts')->where('account_number', $account_number)->value('init');

        $table = $accounts->each(function ($account) use ($total) {
            $account['jie'] = div($account->jie);
            $account['dai'] = div($account->dai);

            $GLOBALS['total'] = div($GLOBALS['total']) + div((($account['jie'] != 0) ? $account['jie'] : 0)) - div((($account['dai'] != 0) ? $account['dai'] : 0));
            $account['yue'] = div($GLOBALS['total']);
        });

        return div($GLOBALS['total']);
    }
}
