<?php

namespace App\Http\Controllers;

use Artisan;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function pullzhifupz()
    {
    	session(['ND' => config('app.MYND')]);  
    	Artisan::call('pull:zfpz');
    	flash()->success('Woohoo', '更新指标和支付令成功');
    	return redirect()->back();
    }

    public function pullsq()
    {
    	session(['ND' => config('app.MYND')]);  
    	Artisan::call('pull:sq');
    	flash()->success('Woohoo', '更新授权指标成功');
    	return redirect()->back();
    }

    public function pullzj()
    {
    	session(['ND' => config('app.MYND')]);  
    	Artisan::call('pull:zj');
    	flash()->success('Woohoo', '更新直接指标成功');
    	return redirect()->back();
    }

    public function updateboss()
    {
    	session(['ND' => config('app.MYND')]);  
    	Artisan::call('pull:updateboss');
    	flash()->success('Woohoo', '更新BOSS成功');
    	return redirect()->back();
    }

    public function pullyue()
    {
    	session(['ND' => config('app.MYND')]);  
    	Artisan::call('pull:yue');
    	flash()->success('Woohoo', '更新余额成功');
    	return redirect()->back();
    }

    public function pullshenqing()
    {
    	session(['ND' => config('app.MYND')]);  
    	Artisan::call('pull:shenqing');
    	flash()->success('Woohoo', '更新支付申请成功');
    	return redirect()->back();
    }

    public function cast()
    {
    	session(['ND' => config('app.MYND')]);  
    	Artisan::call('pull:cast');
    	flash()->success('Woohoo', '更新实时信息成功');
    	return redirect()->back();
    }

    public function cacheclear()
    {
        Artisan::call('cache:clear');
        flash()->success('Woohoo', '清除缓存成功');
        return redirect()->back();
    }

}
