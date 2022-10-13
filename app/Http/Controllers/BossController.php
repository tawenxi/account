<?php

namespace App\Http\Controllers;

use App\Model\Boss;
use Illuminate\Http\Request;

class BossController extends Controller
{
    public function companylist()
    {
        $bosses = Boss::all()->filter(function($item ,$key) {
            return strstr($item->name,'公司');
        });
        
		return view('boss.bosses',compact('bosses'));
    }

    public function personalbosslist()
    {
        $bosses = Boss::all()->filter(function($item ,$key) {
            return !strstr($item->name,'公司');
        });
        
        return view('boss.bosses',compact('bosses'));
    }

    public function poorbosslist()
    {
        $bosses = \App\Model\Zfpz::withoutGlobalScopes()->where('YSDWDM','901012013')->get()
        ->groupBy('SKR')
        ->sortByDesc(function($qq){
         return $qq->sum('JE');
         });

        return view('boss.poorboss',compact('bosses'));
    }


    public function bossDetail($boss, $supportpoor = NULL)
    {
        if ($supportpoor == 1) {
            $results = \App\Model\Zfpz::withoutGlobalScopes()->where('SKR',$boss)->where('YSDWDM','901012013')->get();
            $results= $results->sortByDesc(function($item){
                return filterVillage($item->ZY);
            });
        } else {
            $results = \App\Model\Zfpz::withoutGlobalScopes()->where('SKR',$boss)->get();
        }
		return view('boss.boss',compact('results'));
    }

    public function jingguanzhan($personal=0)
    {
        if ($personal == 1) {
            $results = \App\Model\Zfpz::withoutGlobalScopes()->where('SKR','遂川县左安镇财政所')->where('SKZH','1783401262206010010001')->get();
        } else {
            $results = \App\Model\Zfpz::withoutGlobalScopes()->where('SKR','遂川县左安镇财政所')->where('SKZH','178347750000002933')->get();
        }
        return view('boss.boss',compact('results'));
    }


    public function edit($name)
    {
        $boss = Boss::whereName($name)->first();
        return view('boss.edit', compact('boss'));
    }

    public function update(\Illuminate\Http\Request $request)
    {
        $this->validate($request,
            [
                'description' => 'required',
            ]);

        $boss = Boss::findOrfail($request->id);
        $result = $boss->update(['description'=>trim($request->description)]);
       
        if ($result) {
            flash()->success('Woohoo', '更新成功'); 
            session()->flash('success', '更新成功');

            return redirect()->back();
        }
    }

    public function villagezfl($village)
    {
        $results = \App\Model\Zfpz::withoutGlobalScopes()->where('YSDWDM','901012013')->orderBy('SKR')->get();
        $results = $results->filter(function ($item, $key) use ($village) {
           return strstr($item->ZY, $village);
        });
        return view('boss.boss',compact('results'));
    }
}
