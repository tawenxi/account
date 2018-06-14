<?php

namespace App\Http\Controllers;

use App\Model\Account;
use App\Model\Payout;
use Illuminate\Http\Request;
use App\Model\Zb;
use App\Model\Respostory\Excel;
use App\Model\Zfpz;
use App\PresenterForBlade\ZbdetailPresenter;
use App\PresenterForBlade\ZbPresenter;
use App\Repositories\ZbRepository;
use App\Repositories\ZfpzRepository;
use App\Criteria\WithoutGlobalScopesCriteria;
use App\Criteria\FindZyCriteria;
use App\Criteria\FindSkrOrZyCriteria;
use App\Criteria\FindByZyCriteria;
use App\Criteria\FindByZySkrCriteria;
use App\Criteria\FindTotleCriteria;



class SearchController extends Controller
{

public function __construct(ZfpzRepository $repository_zfpz,
                            ZbRepository $repository_zb,
                            Excel $excel)
    {
        $this->repository_zfpz = $repository_zfpz->pushCriteria(WithoutGlobalScopesCriteria::class);
        $this->repository_zb = $repository_zb->pushCriteria(WithoutGlobalScopesCriteria::class);
        $this->excel = $excel;
    }

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
                if (!is_numeric($query)) {
                        if (substr($query,0,1) == '@') {
                            $query = substr($query,1);
                            $results = $this->repository_zb->pushCriteria(new FindByZyCriteria($query))
                                                           ->orderBy('SH_RQ','desc')
                                                           ->get();
                            $results = $results->map(function($item){
                                return new ZbPresenter($item);
                            });

                            return $this->excel->exportBlade('zhibiao.index', compact('results'));
                        } elseif (substr($query,0,1)  == '[' AND substr($query,-1,1)== ']' AND strstr($query,',')) {
                            $query = substr($query,1,-1);
                            $scope = explode(',', $query);
                            if (!(count($scope) == 2 AND is_numeric($scope[0]) AND is_numeric($scope[1]))) {
                                throw new \Exception('请输入数字范围', 1);
                            }
                            $results = $this->repository_zfpz->scopeQuery(function($_query)use ($scope){
                                return $_query->where('JE', '>=', trim($scope[0])*100)->where('JE', '<=', trim($scope[1])*100)->orderBy('SH_RQ','desc');
                            })->with(['zb','account','project'])->get();
                            $results = $results->map(function($item){
                                    return new ZbdetailPresenter($item);
                                });
                            return $this->excel->exportBlade('zhibiao.detail', compact('results'));
                        } elseif (substr($query,0,1) == '#' AND is_numeric(substr($query,1))) {
                            $query = substr($query,1)*100;
                            $as = \DB::table('zfpzs')
                                    ->select('ZY', \DB::raw('SUM(`JE`) as JE2'),'SKR','PDRQ')
                                    ->groupBy(['ZY','SKR','PDRQ'])
                                    ->havingRaw("JE2 = {$query} AND Count(*) > 1")
                                    ->get();

                            $concatenated = collect();
                            foreach ($as as $a) {
                                $result = $this->repository_zfpz
                                  ->pushCriteria(new FindTotleCriteria($a))->with(['zb','account','project'])->all();
                                $concatenated = $concatenated->merge($result);
                                $this->repository_zfpz->popCriteria(new FindTotleCriteria($a));
                            }

                            $results = $concatenated->map(function($item){
                                    return new ZbdetailPresenter($item);
                                });
                            return $this->excel->exportBlade('zhibiao.detail', compact('results'));
                        }elseif (strstr($query, ' ')) {
                            $keyWords = explode(' ', $query);
                            $concatenated = collect();
                            foreach ($keyWords as $keyword) {
                                $result = $this->repository_zfpz
                                               ->pushCriteria(new FindSkrOrZyCriteria($keyword))
                                               ->with(['zb','account','project'])
                                               ->all();
                                $concatenated = $concatenated->merge($result);
                                $this->repository_zfpz->popCriteria(new FindSkrOrZyCriteria($keyword));
                            }
                            $results = $concatenated->unique();
                        } elseif(strstr($query, '+')){
                            $keyWords = explode('+', $query);
                            $concatenated = collect();
                            foreach ($keyWords as $keyword) {
                                if (isset($result)) {
                                    $result = $result->pushCriteria(new FindZyCriteria($keyword))
                                                     ->with(['zb','account','project']);
                                } else {
                                            $result = $this->repository_zfpz->pushCriteria(new FindZyCriteria($keyword))
                                                                            ->with(['zb','account','project']);
                                        }
                                    }
                            $concatenated = $result->all();
                            $results = collect($concatenated)->unique();
                        } else {
                            $results = $this->repository_zfpz
                                            ->pushCriteria(new FindByZySkrCriteria($query))
                                            ->with(['zb','account','project'])
                                            ->all();
                                        }
                } else {
                    $results = $this->repository_zfpz->scopeQuery(function($_query)use ($query){
                                return $_query->where('JE', $query*100);
                        })->with(['zb','account','project'])->all();
                }    
            }
        }

        $results = $this->presentZfpzs($results);

        return $this->excel->exportBlade('zhibiao.detail', compact('results'))->render();
    }

    public function presentZfpzs($results)
    {
      return $results = $results->map(function($item){
            return new ZbdetailPresenter($item);
        });
    }
}
