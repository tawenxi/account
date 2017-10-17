<?php

namespace App\Http\Controllers;

use App\Model\Account;
use App\Model\Zb;
use App\Model\zfpz;
use Illuminate\Http\Request;

class MakeAccountController extends Controller
{
    public function storeAccount(Request $request)
    {

        //dd($request->all());
        $request = collect($request)->each(function ($item, $key) {
            if (is_numeric($item)) {
                //dump($key);
                $key = str_replace('_', '.', $key);
                $account = Account::where('id', $item)->first();
                $account_number = $account->account_number;
                //dd($key);
                $zb = zfpz::where('PDH', $key)->first();
                //dd($zb->toArray());
                $zb->account_number = $account_number;
                $zb->save();
                $account = zfpz::where('PDH', $key)->first();
                dump($account->toArray());
            }
            //001.2017.201708.0.35103
            //001.2017.201708.0.35102
        });

        return redirect('/zbdetail');
    }

    public function storeaccount_for_zb(Request $request)
    {
        $request = collect($request)->each(function ($item, $key) {
            if (is_numeric($item)) {
                //dump($key);
                $key = str_replace('_', '.', $key);
                $account = Account::where('id', $item)->first();
                $account_number = $account->account_number;
                //dd($key);
                $zb = Zb::where('ZBID', $key)->first();
                //dd($zb->toArray());
                $zb->account_number = $account_number;
                $zb->save();
                $account = Zb::where('ZBID', $key)->first();
                dump($account->toArray());
            }
            //001.2017.201708.0.35103
            //001.2017.201708.0.35102
        });

        return redirect('http://account.app/zhibiao?show=1');
    }
}
