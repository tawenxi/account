<?php

namespace App\Http\Controllers;


use App\Model\Respostory\Excel;
use App\Model\Respostory\GetSqlResult;
use App\Model\Respostory\Guzzle;
use App\Model\Tt\Data;
use DB;
use App\Repositories\ZbRepository;
use App\Repositories\ZfpzRepository;
use App\Repositories\ZjzbRepository;
use Illuminate\Http\Request;
use App\Model\ZbApply;
use App\Criteria\OrderCriteria;
use App\Criteria\WithoutGlobalScopesCriteria;
use App\PresenterForBlade\ZbdetailPresenter;
use App\PresenterForBlade\ZbPresenter;

class ZhibiaoController extends Controller
{
    use Data;

    private $excel;
    private $getperson;
    private $repository_zb;
    private $repository_zfpz;
    private $repository_zjzb; 

    public function __construct(ZfpzRepository $repository_zfpz,
                                ZbRepository $repository_zb,
                                Excel $excel,
                                GetSqlResult $getdetail,
                                ZjzbRepository $repository_zjzb)
    {
        $this->repository_zfpz = $repository_zfpz;
        $this->repository_zb = $repository_zb;
        $this->middleware('auth');
        // $this->middleware('admin');
        // $this->middleware('sudo');
        $this->excel = $excel;
        $this->getdetail = $getdetail;
        $this->repository_zjzb = $repository_zjzb;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        error_log(\Auth::user()->name.'登陆了，登陆时间：'.\Carbon\Carbon::now().PHP_EOL, 3, storage_path($path = '/logs/logins.log'));
        $results = $this->repository_zb->getIndexPage();

        $results = $this->presentZbs($results);
        return $this->excel->exportBlade('zhibiao.index', compact('results'))->render();
    }

    public function ZbHavingFile()
    {
        $results = $this->repository_zb->getZbHavingFile();

        $results = $this->presentZbs($results);
        return $this->excel->exportBlade('zhibiao.index', compact('results'))->render();
    }

    /**
     * 进行数据并查，看看有zbdetails里面有没有数据差错进行调整.
     * url: '/up'
     *
     * @param $zfpzdatas 来自大平台的数据
     */
    public function checkoutZFPZ($zfpzdatas = 0)
    {
        $Zfpz = $this->repository_zfpz->all();
        $Zfpz = $Zfpz->map(function ($a) {
            return collect($a->only(['PDH', 'ZY']))->toJson();
        });
        $zfpzdatas = $this->getdetail->getdata($this->zfpz(), [
                                ["'".config('app.MYND')."0101'", "'".config('app.MYND')."0101'"],
                                ["'".config('app.MYND')."0728'", "to_char(sysdate,'yyyymmdd')"],
                                ]);
        $b = collect($zfpzdatas)->map(function ($a) {
            return collect(collect($a)->only(['PDH', 'ZY']))->toJson();
        })->toarray();
        dd($Zfpz->intersect($b)->count() == $Zfpz->count());
    }

    public function zb_detail(Request $request)
    {
        if (request('only')=='other') {
            $results = $this->repository_zfpz->pushCriteria(WithoutGlobalScopesCriteria::class);
        } else {
            $results = $this->repository_zfpz;
        }

        $results = $results->pushCriteria(OrderCriteria::class)->with(['zb','account','project'])->all();

        if (request('only')=='other') {
            $results = $results->filter(function($item){
                return $item['village'] == '其他';
            });
        }
        
        $results = $this->presentZfpzs($results);

        return $this->excel->exportBlade('zhibiao.detail', compact('results'))->render();
    }

    public function project_payout($project_id)
    {
        $results = $this->repository_zfpz
        ->scopeQuery(function($query) use ($project_id) { 
                return $query->where(['project_id'=>$project_id]);
        })->all()->unique();

        $results = $this->presentZfpzs($results);
        return $this->excel->exportBlade('zhibiao.detail', compact('results'))->render();
    }

    public function checkout()
    {
        $results1 = $this->repository_zfpz->all()
                   ->groupBy('zy_skr')
                   ->filter(function ($item) {
                       return $item->count() > 1;
                   });
        $results = collect();
        foreach ($results1 as $key => $result) {
            $results = $results->merge($result);
        }
        $results = $this->presentZfpzs($results);
        return $this->excel->exportBlade('zhibiao.detail', compact('results'))->render();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($zbid)
    {
        $zbid = str_replace('-', '.', $zbid);
        $results = $this->repository_zfpz->with(['zb','account','project'])->findByField('ZBID', $zbid);

        $results = $this->presentZfpzs($results);
        return $this->excel->exportBlade('zhibiao.detail', compact('results'))->render();
        //return $this->excel->exportBlade('zhibiao.showzbdetail', compact('results'))->render();
    }

    public function getdetails()
    {
        $person = $this->getdetail->getdata($this->zfpz(), [
            ["'".config('app.MYND')."0728'", "to_char(sysdate,'yyyymmdd')"], ]);
        dd($person);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $zfpz = \App\Model\Zfpz::find($request->id);
        $account_number = \App\Model\Account::find($request->account_id)->account_number;
        $zfpz->JE = $request->JE;
        $zfpz->account_number = $account_number;
        $zfpz->save();
        flash()->success('Woohoo', '更新成功'); 
        return back()->with('success','更新成功');
    }

    public function inco()
    {
        $results = $this->repository_zfpz->orderBy('PDRQ', 'desc')->with(['zb','account','project'])->all()->unique();

        return $this->excel->exportBlade('zhibiao.inco', compact('results'))->render();
    }


    public function edit($id)
    {
       $result = $this->repository_zfpz->find($id);
       return view('zhibiao.editaccount', compact('result'));
    }

    public function shenqing()
    {
        $results = ZbApply::all();
        return $this->excel->exportBlade('zhibiao.showapply', compact('results'));

    }

    public function rediscache()
    {
        $updatedZfpzs = \Cache::get('updatedZfpz');
        $updatedZbs = \Cache::get('updatedZb');

        return view('zhibiao.rediscache',compact('updatedZfpzs','updatedZbs'));
    }

    public function zhijie()
    {
        $results = $this->repository_zjzb->all()->unique();
       
        return $this->excel->exportBlade('zhibiao.zhijie', compact('results'))->render();
    }


    public function blade(Request $request)
    {

        $results = \App\Model\Zfpz::where('qs',1)->where('QS_RQ','like',$request->qj.'%')->where('account_number','!=','4011002')->orderBy('account_number')->with(['account'])->get()->toarray();
         
          $results = collect($results)->groupBy('account_number');
          $filter = $results->filter(function($item,$key){
            return $key == 50013010101;
          });

          $results = $results->reject(function($item,$key){
            return $key == 50013010101;
          });

          $results = $results->push($filter->first());
          $results = $results->values()->map(function($item ,$key2){
                 return $item->map(function($item2,$key) use ($key2) {
                    $item2['hanghao'] = $key+1;
                    $item2['list_id'] = $key2+3;
                    return $item2;
            });
          });                          
        $results = $results->flatten(1);

        //$results = $this->presentZfpzs($results);
        
       if ($request->text == 1) {
           return $this->excel->exportBlade('zhibiao.testblade', compact('results','request'))->render();
       }
       return $this->excel->exportBlade('zhibiao.blade', compact('results','request'))->render();
    }


    public function sourcezb($zbid)
    {
      
      $zbid = $this->repository_zb->pushCriteria(WithoutGlobalScopesCriteria::class)->findByField('ZBID', $zbid)->first();
     
      $zbids = [$zbid->ZBID];
      while ($zbid = $zbid->prezbid()) {
          $zbids[] = $zbid->ZBID;
      }
      $results = $this->repository_zfpz->pushCriteria(WithoutGlobalScopesCriteria::class)->findWhereIn('ZBID', $zbids);
      $results = $this->presentZfpzs($results);
      return $this->excel->exportBlade('zhibiao.detail', compact('results'))->render();
    }

    public function presentZfpzs($results)
    {
      return $results = $results->map(function($item){
            return new ZbdetailPresenter($item);
        });
    }

    public function presentZbs($results)
    {
      return $results = $results->map(function($item){
            return new ZbPresenter($item);
        });
    }

    public function overview()
    {
        $results = DB::table('zfpzs')
             ->select(DB::raw('LEFT(QS_RQ,6) as peroid, count(*) as count, round(sum(JE)/100,2) as amount'))
             ->where('qs',1)
             ->groupBy('peroid')
             ->get();

      $datas = \DB::table('zbs')
                 ->select(DB::raw('LEFT(SH_RQ,6) as peroid, count(*) as count, round(sum(JE)/100,2) as amount'))
                 ->groupBy('peroid')
                 ->get();

        return view('zhibiao.overview',compact('results','datas'));
    }

}
