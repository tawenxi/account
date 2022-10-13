<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rccount\Account;
use App\Rccount\Robot;

class AccountController extends Controller
{


	public function __construct(Robot $robot)
    {
        $this->robot = $robot;
    }

    public function search(Request $request) 
    {
    	//dd($request->all());
    	$account_number = $request->q;
    	//dd($account_number);
    	if (is_numeric($account_number)) {
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
            $results = collect($table);
            return view('account.account', compact('results','account_number'));
           // dd($table);
           // $this->table($headers, $table);

        }
    }



	public function balance()
	{
		$kemus = \App\Model\Account::all();
        $results = $kemus->map(function ($kemu) {
            $balance = [];
            $balance['kmdm'] = $kemu->account_number;
            $balance['kmmc'] = $kemu->account_name;
            $yue = $this->robot->GetBalance($kemu->account_number);
            if ($yue > 0) {
                $balance['jdbz'] = '借';
            } elseif ($yue < 0) {
                $balance['jdbz'] = '贷';
            } else {
                $balance['jdbz'] = '平';
            }
            $balance['balance'] = $yue;

            return $balance;
        })->toarray();

        $results = collect($results);
            return view('account.balance', compact('results'));

	}
}
