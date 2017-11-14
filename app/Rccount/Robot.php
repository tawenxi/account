<?php

namespace App\Rccount;

class Robot
{
    public function check_last_balance($list_id)
    {
        $jie = Fenlu::where('list_id', $list_id - 1)
                    ->where('jdbz', '借')->sum('je');
        $dai = Fenlu::where('list_id', $list_id - 1)
                    ->where('jdbz', '贷')->sum('je');
        //echo $jie."   ".$dai;
        if ($jie != $dai && $jie == 0) {
            //dd(222);
            return $this->be_balance('jie', $dai);
        } elseif ($jie != $dai && $dai == 0) {
            //dd(222);
            return $this->be_balance('dai', $jie);
        } elseif ($jie == $dai) {
            return true;
        } else {
            $wrong_id = $list_id - 1;
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
            return true;
        } else {
            dd($jie, $dai);
            dd('无法借贷平衡');
        }
    }

    public function GetBalance($account_number)
    {
        $accounts = Account::Where('kmdm', $account_number)
        ->where('fzdm10', '')
        ->get();

        global $total;
        $total = \DB::table('accounts')->where('account_number', $account_number)->value('init');

        $table = $accounts->each(function ($account) use ($total) {
            $account['jie'] = round($account->jie, 2);
            $account['dai'] = round($account->dai, 2);

            $GLOBALS['total'] = round($GLOBALS['total'], 2) + round((($account['jie'] != 0) ? $account['jie'] : 0), 2) - round((($account['dai'] != 0) ? $account['dai'] : 0), 2);
            $account['yue'] = round($GLOBALS['total'], 2);
        });

        return round($GLOBALS['total'], 2);
    }
}
