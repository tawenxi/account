<?php

namespace App\Http\Controllers;

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
        $projects = project::with(['zfpzs','village'])->village($village_id)->orderBy('year')->get();

        return view('project.index',compact('projects'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        Project::withoutGlobalScopes()->locatedAt($id)->update($request->except(['_method','_token']));
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
        //
    }


    public function project_income($project_id)
    {
        
        $zbs = Project::find($project_id)->zbs;


        return view('project.income', compact('zbs'))->render();
    }



    public function village()
    {
        $villages = Village::where('year','<>',0)->with('projects')->get();
        return view('project.village',compact('villages'));
    }

}
