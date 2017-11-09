<?php

namespace App\Http\Controllers;

use App\Model\Respostory\Excel;
use App\Model\Respostory\GetSqlResult;
use App\Model\Respostory\Guzzle;
use App\Model\Tt\Data;
use App\Repositories\ZbRepository;
use App\Repositories\ZfpzRepository;
use Illuminate\Http\Request;

class ZhibiaoController extends Controller
{
    use Data;

    private $excel;
    private $guzzleexcel;
    private $getperson;
    private $repository_zb;
    private $repository_zfpz;

    public function __construct(ZfpzRepository $repository_zfpz,
                                ZbRepository $repository_zb,
                                Excel $excel,
                                GetSqlResult $getdetail)
    {
        $this->repository_zfpz = $repository_zfpz;
        $this->repository_zb = $repository_zb;
        $this->middleware('auth');
        // $this->middleware('admin');
        // $this->middleware('sudo');
        $this->excel = $excel;
        $this->getdetail = $getdetail;
        $this->guzzleexcel = \App::make(Excel::class, ['excel']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Guzzle $guzzle)
    {
        if (strstr($request->ip(), '192.168') and !(\Request::has('show'))  And FALSE) {
            $zb_data = $guzzle->get_ZB();
            $collection = collect($zb_data);
            $collection = $collection->map(function ($item) {
                $info = $this->repository_zb->scopeQuery(function ($query) use ($item) {
                    return $query->updateOrCreate(['ZBID' => $item['ZBID']], $item);
                });

                return $info;
            });
            if (\Request::has('update') And FALSE) {
                $zfpzdatas = $this->getdetail->getdata($this->zfpz, [
                                ["'20170101'", "'20170801'"],
                                ["'20170821'", "to_char(sysdate,'yyyymmdd')"],
                                ]);
                foreach ($zfpzdatas as $zfpzdata) {
                    $this->repository_zfpz->scopeQuery(function ($query) {
                        return $query->updateOrCreate(['PDH' => $zfpzdata['PDH']], $zfpzdata);
                    });
                }
            }
        }
        $results = $this->repository_zb->orderBy('LR_RQ', 'desc')->all()->unique();

        return $this->excel->exportBlade('zhibiao.index', compact('results'))->render();
    }

    /**
     * 进行数据并查，看看有zbdetails里面有没有数据差错进行调整.
     *
     * @param $zfpzdatas 来自大平台的数据
     */
    public function checkoutZFPZ($zfpzdatas = 0)
    {
        $Zfpz = $this->repository_zfpz->all();
        $Zfpz = $Zfpz->map(function ($a) {
            return collect($a->only(['PDH', 'ZY']))->toJson();
        });
        $zfpzdatas = $this->getdetail->getdata($this->zfpz, [
                                ["'20170101'", "'20170101'"],
                                ["'20170821'", "to_char(sysdate,'yyyymmdd')"],
                                ]);
        $b = collect($zfpzdatas)->map(function ($a) {
            return collect(collect($a)->only(['PDH', 'ZY']))->toJson();
        })->toarray();
        dd($Zfpz->intersect($b)->count() == $Zfpz->count());
    }

    public function zb_detail(Request $request)
    {
        $results = $this->repository_zfpz->scopeQuery(function($query) use ($request) {
            if ($request->has('orderBy')) {
                return $query;
            } else {
                return $query->orderBy('QS_RQ', 'desc');
            }
            
        })->all()->unique();

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

        return $this->excel->exportBlade('zhibiao.detail', compact('results'))->render();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
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
        $results = $this->repository_zfpz->findByField('ZBID', $zbid)->all();

        return $this->excel->exportBlade('zhibiao.showzbdetail', compact('results'))->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function showzf($id)
    {
        $person = $this->getperson->getpersondata($id);
        dd($person);
    }

    public function showallzf()
    {
        $person = $this->getzf->getpersondata();
        dd($person);
    }

    public function showallsf()//申请
    {
        $person = $this->getsf->getpersondata();
        dd($person);
    }

    public function getdetails()
    {
        $person = $this->getdetail->getdata($this->zfpz, [
            ["'20170821'", "to_char(sysdate,'yyyymmdd')"], ]);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function inco()
    {
        $results = $this->repository_zfpz->orderBy('PDRQ', 'desc')->all()->unique();

        return $this->excel->exportBlade('zhibiao.inco', compact('results'))->render();
    }
}
