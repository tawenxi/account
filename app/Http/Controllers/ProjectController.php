<?php

namespace App\Http\Controllers;

use App\Model\Zb;
use App\Model\Zfpz;
use Illuminate\Http\Request;
use App\Model\Project\Village;
use App\Model\Project\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $village_id = $request->village?$request->village:'0';
        $projects = project::with(['zfpzs','village','zbs']);
        if ($request->village) 
            $projects = $projects->where('village_id','=',$village_id)->orderBy('year');
        $projects = $projects->get();
        return view('project.index',compact('projects'));
    }

    public function index_chart(Request $request)
    {
               $village_id = $request->village?$request->village:'0';
        $projects = project::with(['zfpzs','village','zbs'])->village($village_id)->orderBy('year')->get();

        $projects = $projects->mapWithKeys(function($project){
            return [$project->name=>$project->zbs->sum(function($item){
                                    return $item->pivot->amount;
                                })];
        });

        return view('chart',compact('projects'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        'category' => 'required',
        'name' => 'required',
        'bidprice' => 'required|numeric',
        'budget' => 'required|numeric',
        'contractprice' => 'required|numeric',
        'settlementprice' => 'required|numeric',
        ]);
        Project::create($request->all());
        flash()->success('Woohoo', '新建项目成功');
        \Session::flash('success', '新建项目成功');
        return redirect()->route('project.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('project.edit',compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Project::locatedAt($id)->update($request->except(['_method','_token','village']));
        flash()->success('Woohoo', '项目信息更新成功');        
        \Session::flash('success', '项目信息更新成功');
        return redirect()->route('project.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Project::find($id)->delete();
        flash()->success('Woohoo', '项目信息删除成功');
        \Session::flash('success', '项目信息删除成功');
        return redirect()->route('project.index');
    }


    public function project_income($project_id)
    {
        
        $zbs = Project::find($project_id)->zbs;


        return view('project.income', compact('zbs'))->render();
    }



    public function village(Request $request)
    {
        $biaozhi = $request->year?2:0;
        $villages = Village::where('year','<>',$biaozhi)->with('projects')->get();
        return view('project.village',compact('villages'));
    }

    public function divider($zb)
    {
        $zb = Zb::withoutGlobalScopes()->find($zb);
        $projects = Project::all();
        return view('project.divider',compact('projects','zb'));
    }

    public function handleDivider(Request $request)
    {
        $zb = Zb::find($request['id']);
        $zb->KYX = $request['KYX'];
        $zb->beizhu = $request['beizhu'];
        $zb->save();
        if ($zb->originzbid) {
            $zb = $zb->transforToOrigin();
            \Session::flash('warning', '分配的是原始指标');
        }
        $is_enough = $zb->judgeAmountEnough($request);

        if (!$is_enough) {
            flash()->error('Woohoo', '指标分配失败');
            return redirect()->back();
        }

        if ($request['amount'] != 0) $zb->divide($request['project_id'], $request['amount']);
        flash()->success('Woohoo', '指标分配成功');
        return redirect()->back();
    }


    public function deletezb(Request $request)
    {
        Zb::withoutGlobalScopes()->find($request['zb_id'])->deletedivide($request['project_id'], $request['amount']);
        flash()->success('Woohoo', '删除分配成功');
        \Session::flash('success', '删除分配成功');
        return redirect()->back();
    }

    public function point($zfpz)
    {
        $zfpz = Zfpz::find($zfpz);

        $projects = Project::all();

        return view('project.point',compact('projects','zfpz'));
    } 

    public function handlePoint(Request $request)
    {
        $zfpz = Zfpz::find($request['id']);
        $zfpz->update(['beizhu'=>$request['describe'], 'fail'=>$request['fail'], 'ZY'=>$request['ZY']]);
        $zfpz->point($request['project_id']);
        flash()->success('Woohoo', '指标分配成功');
        \Session::flash('success', '指标分配成功');
        return redirect()->back();
    }   

}
