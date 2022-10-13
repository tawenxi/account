<?php

namespace App\Http\Controllers;

use App\Criteria\HasJJCriteria;
use App\Criteria\MonthSearchCriteria;
use App\Criteria\YearSearchCriteria;
use App\Model\Respostory\Excel;
use App\Model\Respostory\SalarySum;
use App\Model\User;
use App\Repositories\SalaryRepository;
use App\Validators\SalaryValidator;
use Auth;

class SalaryController extends Controller
{
    private $excel;
    private $salarySum;

    public function __construct(Excel $excel, SalarySum $salarySum, SalaryRepository $repository, SalaryValidator $validator)
    {
        $this->salarySum = $salarySum;
        $this->middleware('auth');
        // $this->middleware('admin', ['except' => ['geren']] );
        $this->excel = $excel;
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function index($date = "", $jj = null)
    {

        $date = ($date!='')?$date:config('app.MYND')."01";
        $dt = $date;
        $res = $this->repository
                ->pushCriteria(new MonthSearchCriteria($dt))
                ->pushCriteria(new HasJJCriteria($jj))
                ->all()
                ->groupBy('member_id');
        //dd($res);
        $dates = $this->repository
                  ->pluck('date')
                  ->unique();
        $resv = $this->repository
                ->pushCriteria(new MonthSearchCriteria($dt))
                ->pushCriteria(new HasJJCriteria($jj))
                ->all();
        $real_title = $this->salarySum->getObject($resv)->getTitle();

        return $this->excel->exportBlade('salary.index', compact('resv', 'res', 'dates', 'real_title'))->render();
    }

    public function bumen($date = '', $jj = null)
    {
        $date = ($date!='')?$date:config('app.MYND')."01";
        $dt = $date;
        $res = $this->repository
                ->pushCriteria(new MonthSearchCriteria($dt))
                ->pushCriteria(new HasJJCriteria($jj))
                ->all()
                ->groupBy('bumen');

        $resv = $this->repository
                ->pushCriteria(new MonthSearchCriteria($dt))
                ->pushCriteria(new HasJJCriteria($jj))
                ->all();
        $real_title = $this->salarySum->getObject($resv)->getTitle();

        $dates = $this->repository
                     ->pluck('date')
                     ->unique();

        return $this->excel->exportBlade('salary.bumen', compact('res', 'dates', 'resv', 'real_title'))->render();
    }

    public function geren($id = 0, $jj = null)
    {
        $id = $id ? $id : Auth::user()->id;
        if (\Auth::user()->id != 39 && \Auth::user()->id != 36) {
            if (\Auth::check()) {
                $id = \Auth::user()->id;
            }
            $this->authorize('update', User::find($id));
        }

        error_log(\Auth::user()->name.'登陆了，登陆时间：'.\Carbon\Carbon::now().PHP_EOL, 3, storage_path($path = '/logs/logins.log'));

        $res = $this->repository
                   ->pushCriteria(new HasJJCriteria($jj))
                   ->findByField('member_id', $id)
                   ->groupBy('date');

        $resv = $this->repository
                   ->pushCriteria(new HasJJCriteria($jj))
                   ->findByField('member_id', $id);

        $dates = $this->repository
                     ->pluck('date')
                     ->unique();
        $real_title = $this->salarySum->getObject($resv)->getTitle();

        return $this->excel->exportBlade('salary.geren', compact('res', 'dates', 'resv', 'real_title'))->render();
    }

    public function byear($year = '', $jj = null)//1只显示工资，2只显示奖金
    {
      $year = ($year!='')?$year:config('app.MYND');
      $res = $this->repository
              ->pushCriteria(new YearSearchCriteria(session('ND')))
              ->pushCriteria(new HasJJCriteria($jj))
              ->all()
              ->groupBy('bumen');

        $resv = $this->repository
              ->pushCriteria(new YearSearchCriteria(session('ND')))
              ->pushCriteria(new HasJJCriteria($jj))
              ->all();

        $dates = $this->repository
                     ->pluck('date')
                     ->unique()
                     ->map(function ($v) {
                         return $v = substr($v, 0, 4);
                     })->toarray();

        $dates = collect($dates);
        $dates = $dates->unique();
        $dates->values()->all();
        $real_title = $this->salarySum->getObject($resv)->getTitle();

        return $this->excel->exportBlade('salary.byear', compact('res', 'dates', 'resv', 'real_title'))->render();
    }

    public function myear($year = '', $jj = null)//1只显示工资，2只显示奖金
    {
      $year = ($year!='')?$year:config('app.MYND');

      $res = $this->repository
              ->pushCriteria(new YearSearchCriteria(session('ND')))
              ->pushCriteria(new HasJJCriteria($jj))
              ->all()
              ->groupBy('date');

        $resv = $this->repository
              ->pushCriteria(new YearSearchCriteria(session('ND')))
              ->pushCriteria(new HasJJCriteria($jj))
              ->all();

        $dates = $this->repository
                     ->pluck('date')
                     ->unique()
                     ->map(function ($v) {
                         return $v = substr($v, 0, 4);
                     })->toarray();
        $dates = collect($dates);
        $dates = $dates->unique();
        $dates->values()->all();
        $real_title = $this->salarySum->getObject($resv)->getTitle();

        return $this->excel->exportBlade('salary.myear', compact('res', 'dates', 'resv', 'real_title'))->render();
    }

    public function phb($year = '', $jj = null)//1只显示工资，2只显示奖金
    {
      $year = ($year!='')?$year:config('app.MYND');

      $res = $this->repository
                ->pushCriteria(new YearSearchCriteria(session('ND')))
                ->pushCriteria(new HasJJCriteria($jj))
                ->all()
                ->groupBy('name')
                ->sortByDesc(function ($product, $key) {
                    return
                    $product->sum('yishu_bz') +
                    $product->sum('tuixiu_gz') +
                    $product->sum('jb_gz1') +
                    $product->sum('jb_gz2') +
                    $product->sum('jinbutie') +
                    $product->sum('gongche_bz') +
                    $product->sum('xiangzhen_bz') +
                    $product->sum('bufa_gz') +
                    $product->sum('nianzhong_jj') +
                    $product->sum('gaowen_jiangwen') +
                    $product->sum('jiangjin') +
                    $product->sum('gjj_dw') +
                    $product->sum('sb_dw') -
                    (
                    $product->sum('gjj_gr') +
                    $product->sum('gjj_dw') +
                    $product->sum('sb_gr') +
                    $product->sum('sb_dw') +
                    $product->sum('zhiye_nj') +
                    $product->sum('daikou_gz') +
                    $product->sum('fanghong_zj') +
                    $product->sum('yiliao_bx') +
                    $product->sum('shiye_bx') +
                    $product->sum('shengyu_bx') +
                    $product->sum('gongshang_bx') +
                    $product->sum('yirijuan') +
                    $product->sum('other_daikou') +
                    $product->sum('tiaozheng_gjj') +
                    $product->sum('tiaozheng_sb')
                    );
                });
        $resv = $this->repository
                   ->pushCriteria(new YearSearchCriteria(session('ND')))
                   ->pushCriteria(new HasJJCriteria($jj))
                   ->all();

        $real_title = $this->salarySum->getObject($resv)->getTitle();

        return $this->excel->exportBlade('salary.phb', compact('res', 'resv', 'real_title'))->render();
    }
}
