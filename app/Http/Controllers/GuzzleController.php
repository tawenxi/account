<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;
use App\Acc\Acc;
use App\Model\Guzzledb;
use App\Model\Payout;
use App\Model\Respostory\Excel;
use App\Model\Respostory\Getsqzb;
use App\Model\Respostory\Guzzle;
use App\Model\Respostory\Http;
use App\Repositories\GuzzledbRepository;

class GuzzleController extends Controller
{
    use \App\Model\Tt\Data;
    private $excel;
    private $guzzleexcel;
    private $repository;

    public function __construct(Excel $excel, GuzzledbRepository $repository)
    {
        //$this->middleware('auth');
        // $this->middleware('admin');
        // $this->middleware('sudo');
        $this->excel = $excel;
        $this->repository = $repository;
        //dd($this->guzzleexcel);
    }

    /**
     * 更新并显示最新的授权指标数据.
     */
    public function dpt(Guzzle $guzzle)  //带了更新功能
    {
        session(['ND'=>config('app.MYND')]);
        \Artisan::call('pull:dpt');
        flash()->success('Woohoo', '更新平台成功');
        \Session::flash('success', '更新平台成功');
        return redirect('/hyy');
    }

    /**
     * 显示最新的授权指标数据(不更新).
     */
    public function hyy()
    {
        $guzzledbs = $this->repository->orderBy('ZJXZMC', 'Asc')
                ->orderBy('KYJHJE', 'desc')
                ->all();
                
        return $this->excel->exportBlade('guzzle.index', compact('guzzledbs'));
    }

    /**
     * 数据验证，预览.
     */
    public function preview()
    {
        $this->guzzleexcel = $this->excel->setExcelFile('excel');
        //header('Content-Type: text/html;charset=utf-8');
        $searchobject = \App::make('acc'); //初始化
        $arr = $this->guzzleexcel->setSkipNum()->getexcel()->each(function ($item) use ($searchobject) {
            $item['kemuname'] = stristr($item['kemu'], '@') ? $item['kemu'] : $searchobject->findac($item['kemu']);
        })->toArray();

        foreach ($arr as $key => $data) {
            if (count($arr[$key]['kemuname']) == 1 && is_array($arr[$key]['kemuname'])) {
                $arr[$key]['kemuname'] = (string) (reset($arr[$key]['kemuname']));
            }
            $Validator = \Validator::make($arr[$key], [
                'payeeaccount'=> 'numeric',
                'amount'      => 'numeric|between:0.01,3000000',
                'zbid'        => 'min:15|max:16',
                ], [
                'numeric'     => ':attribute 必须为纯数字',
                'size'        => ':attribute 必须为15位',
                ], ['zbid'    => '指标ID',
                'amount'      => '金额',
                'payeebanker' => '银行账号',
            ]);
            if ($Validator->fails()) {
                return \Redirect::to('/hyy')->withErrors($Validator);
            }
        }
        $collection = collect($arr);

        return $this->excel->exportBlade('guzzle.preview', compact('collection'));
    }

    /**
     * 进行数据验证并且制单操作.
     */
    public function index()
    {
        $exitCode = Artisan::call('insert:sq', [
        '--force' => true,
        ]);
        
        session()->flash('success', $successi.'条数据拨款成功');

        return redirect()->action('GuzzleController@hyy');
    }

    /**
     * 保存数据源数据.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $request->body = trim($request->body);
        $zbid = $request->zbid;
        $zbidmowei = substr($zbid, -4);
        $this->validate($request,
            [
                'body' => "required|min:4000|max:7000|regex:/<?xml.+to_char%28iPDh%2B1%29%2C%270%27%2C%20%20zfpzdjbh.+178190121002547948.+zhaiyao.+$zbidmowei.+<\/R9PACKET>/", //必填 必须32位//叶涛的账号
            ], [

            'body.regex' => '数据源格式不正确,请检查Fillder是否有误或者支付类型有变', ]);
        $Guzzledb = $this->repository->findByField('ZBID', $zbid)->first();
        $a = $Guzzledb->update(['body'=>trim($request->body),'useable'=>$request->useable]);
        if ($a) {
            flash()->success('Woohoo', '更新成功'); 
            session()->flash('success', '更新成功');

            return redirect()->action('GuzzleController@edit', $request->id);
        }
    }

    /**
     * 查询授权支付历史记录.
     */
    public function payoutlist(\Illuminate\Http\Request $request)
    {   //$a='created_at';
        $a = is_null($request->order) ? 'created_at' : $request->order;
        $my = is_null($request->my) ? '50' : $request->my;

        $date1 = $request->has('date1') ? $request->get('date1') : date('Y-m-01', time());
        $date2 = $request->has('date2') ? $request->get('date2') : date('Y-m-d H:i:s', time() + 86400);
        $payoutdatas = Payout::whereBetween('created_at', [$date1, $date2])->orderBy($a, 'desc')->paginate($my);

        return $this->excel->exportBlade('guzzle.payout', compact('payoutdatas', 'a', 'my', 'date1', 'date2'));
    }

    /**
     * 根据ZBID查询可用指标.
     */
    public function show($id)
    {
        $payoutdatas = Payout::where('zbid', $id)
           ->orderBy('created_at', 'desc')
           ->paginate(10);

        return $this->excel->exportBlade('guzzle.show', compact('payoutdatas'));
    }

    /**
     * 编辑支付科目.
     */
    public function editkemu($id)
    {
        $detail = Payout::find($id);

        return view('guzzle.editkemu', compact('detail'));
    }

    /**
     * 保存编辑的支付科目.
     */
    public function savekemu(\Illuminate\Http\Request $request)
    {
        $this->validate($request,
            [
                'kemuname'     => 'required|regex:/.+@.+/', //必填 必须32位
                'amount'       => 'required|numeric', //必填 必须32位
                'payeeaccount' => 'required|alpha_num',

            ]);

        $detail = Payout::findOrfail($request->id);
        $a = $detail->update(['kemuname'=>trim($request->kemuname)]);
        if ($a) {
            flash()->success('Woohoo', '更新成功'); 
            session()->flash('success', '更新成功');

            return redirect()->action('GuzzleController@editkemu', $request->id);
        }
    }

    /**
     * 编辑的数据源科目.
     */
    public function edit(Guzzledb $guzzledb)
    {
        //$guzzledb = Guzzledb::findOrfail($id);
        return view('guzzle.edit', compact('guzzledb'));
    }

    /**
     * 删除拨款记录.
     */
    public function destroy($id)
    {
        $payout = Payout::findOrFail($id);
        $payout->delete();
        session()->flash('success', '成功删除拨款记录！');

        return back();
    }

    /**
     * 发送修改页面请求
     */
    public function postsql(\Illuminate\Http\Request $request, \App\Model\Respostory\Http $http)
    {
        $Zy = $request->zy ? "Zy='{$request->zy}'" : '';
        $Skrkhyh = $request->banker ? "Skrkhyh='{$request->banker}'," : '';
        $Skzh = $request->account ? "Skzh='{$request->account}'," : '';
        $Skr = $request->payee ? "Skr='{$request->payee}'," : '';
        $je = $request->amount ? "je={$request->amount}" : '';
        $oldje = $request->oldamount ? "je={$request->oldamount}" : '';

        $request['body'] =
<<<EOF
<?xml version="1.0" encoding="GB2312"?><R9PACKET version="1"><SESSIONID></SESSIONID><R9FUNCTION><NAME>AS_DataRequest</NAME><PARAMS><PARAM><NAME>ProviderName</NAME><DATA format="text">DataSetProviderData</DATA></PARAM><PARAM><NAME>Data</NAME><DATA format="text">begin  declare   ierrCount smallint;   szDjBh Varchar(20);   iRowCount smallint ;   iFlen int ;  begin   declare     iPDh int ;     szRBH  char(6) ;     TempExp Exception ;   begin  select '{$request->djbh}' into szDjBh from dual ;  select count(*) into iRowCount from zb_zfpzml_y  where gsdm='001'    and kjnd=to_char(sysdate,'yyyy')    and pdqj=to_char(sysdate,'yyyymm')  and  pdh='{$request->pid}' ; if iRowCount&gt;0 then  update ZB_ZFPZNR_Y set {$je}   where gsdm='001'    and kjnd=to_char(sysdate,'yyyy')    and {$oldje} and  pdqj=to_char(sysdate,'yyyymm')  and  pdh='{$request->pid}' and rownum=1;  update zb_zfpzml_y set {$Skr} {$Skzh} {$Skrkhyh} {$Zy} where Gsdm='001'    and KJND=to_char(sysdate,'yyyy') and  Zy='{$request->zy}'   and  PDQJ=to_char(sysdate,'yyyymm')    and PDH='{$request->pid}' and rownum=1; commit;     select 100 into ierrCount from dual ;  else rollback; end if ;   Exception     when others then       RollBack;       select 0 into ierrCount from dual ;   end ;   Open :pRecCur for     select ierrCount RES,szDJBH DJBH from dual;  end; end; </DATA></PARAM></PARAMS></R9FUNCTION></R9PACKET>
EOF;

        $this->validate($request,
            [
                'zy'        => 'required',
                'amount'    => 'required',
                'oldamount' => 'required',
            ], [

            'zy.required'        => '摘要必填',
            'amount.required'    => '金额必填',
            'oldamount.required' => '原金额必填', ]);
        $sql = $request->body;
        $sql = iconv('UTF-8', 'GB2312', $sql);
        $info = $http->makerequest($sql);
        echo $sql;
        echo "<br\><br\><br\><br\>";
        dd($info);
    }

    /**
     * 渲染修改页面.
     */
    public function getsql()
    {
        return view('guzzle.getsql');
    }

    public function export_account()
    {
        $guzzledbs = $this->repository->orderBy('ZJXZMC', 'Asc')
                ->orderBy('KYJHJE', 'desc')
                ->all();
        \Excel::create('New file', function ($excel) use ($guzzledbs) {
            $excel->sheet('New sheet', function ($sheet) use ($guzzledbs) {
                $sheet->loadView('guzzle.index', ['guzzledbs' => $guzzledbs]);
            })->export('xls');
        });
    }

    public function jiema()
    {
        $datas = [
        'findquery_xingzheng' => $this->findquery_xingzheng(),
        'findquery_benji'     => $this->findquery_benji(),
        'RZ_data'             => $this->RZ_data(),
        'FJ_data'             => $this->FJ_data(),
        'zhibiao_sql'         => $this->zhibiao_sql(),

        'zfpz'                => $this->zfpz(),
        'shenqingsql'         => $this->shenqingsql(),
        'zhijie_zhifu_data'   => $this->zhijie_zhifu_data(),
        ];

        foreach ($datas as $key => $data) {
            dump($key, iconv('GB2312', 'UTF-8', urldecode($data)));
            //dump(substr(urldecode($data), 1));
        }
    }
}
