<?php

namespace App\Http\Controllers;

use App\Model\Account;
use App\Model\Payout;
use Illuminate\Http\Request;
use App\Model\Zfpz;

class SearchController extends Controller
{
    public function account()
    {
        return view('search.account')->render();
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $key = $request->account_name;
        $result = Account::where('account_name', 'like', "%$key%")->get();

        return \Response::json([
            'status'=> 'success',
            'task'  => $result,
            ]);
    }

    public function addstore(Request $request)
    {
        $result = Account::create(
            ['account_name'  => $request->account_name,
             'account_number'=> $request->account_number,
             'name' =>$request->account_number.'@'.$request->account_name,
             'init'=>0]);

        return \Response::json([
            'status'=> 'success',
            'task'  => $result,
            ]);
    }

    public function payout(Request $request)
    {
        $key = $request->zhaiyao;
        $result = Payout::where('zhaiyao', 'like', "%$key%")
        ->Orwhere('payee', 'like', "%$key%")
        ->Orwhere('amount', 'like', "%$key%")
    //     ->Orwhere(function ($query) use($key) {
    // $query->where('created_at', '>', "$key"."-01 00:00:00")
    //       ->Where('created_at', '<', "$key"."-31 24:00:00");})
        ->get();

        return \Response::json([
            'status'=> 'success',
            'task'  => $result,
            ]);
    }

    public function payout_with_date(Request $request)
    {
        $key = $request->zhaiyao;
        $result = Payout::Orwhere(function ($query) use ($key) {
            $query->where('created_at', '>', "$key".'-01 00:00:00')
           ->Where('created_at', '<', "$key".'-31 24:00:00');
        })
        ->get();

        return \Response::json([
            'status'=> 'success',
            'task'  => $result,
            ]);
    }

    public function modifyacc()
    {
        return view('search.modifyacc')->render();
    }   


    public function search(Request $request)
    {
        $query = $request->get('q');
        try {
            $results = [];
            if ($query) {
                $results = Zfpz::search($query)->paginate(1000);
            }
        } catch (\Exception $e) {
            if ($e->getmessage()!='') {
                if (strstr($query, ' ')) {
                    $keyWords = explode(' ', $query);
                    $concatenated = collect();
                    foreach ($keyWords as $keyword) {
                        $result = Zfpz::withoutGlobalScopes()->where('ZY', 'like', '%'.$keyword.'%')->orWhere('SKR' ,'like', '%'.$keyword.'%')->get();
                        $concatenated = $concatenated->merge($result);
                    }
                    $results = $concatenated->unique();
                } elseif(strstr($query, '+')){
                    $keyWords = explode('+', $query);
                    $concatenated = collect();
                    foreach ($keyWords as $keyword) {
                        if (isset($result)) {
                            $result = $result->where('ZY', 'like', '%'.$keyword.'%');
                        } else {
                            $result = Zfpz::withoutGlobalScopes()->where('ZY', 'like', '%'.$keyword.'%');
                        }
                    }
                    $concatenated = $result->get();
                    $results = $concatenated->unique();
                } else{
                    $results = Zfpz::withoutGlobalScopes()->where('ZY', 'like', '%'.$query.'%')->orWhere('SKR' ,'like', '%'.$query.'%')->get();
                }
                
            }
        }
        return view('zhibiao.detail', compact('results', 'query'));
    }
}
