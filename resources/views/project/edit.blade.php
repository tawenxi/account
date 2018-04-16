@extends('layouts.default')
@section('title', '更新个人资料')

@section('content')
<div class="offset-md-2 col-md-8">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h1>更新项目数据</h1>
    </div>
      <div class="panel-body">

        @include('shared.errors')

        <div class="gravatar_edit">
          <a href="http://gravatar.com/emails" target="_blank">
            <img src="" alt="" class="gravatar"/>
          </a>
        </div>

            @if($project->id)
                <form action="{{ route('project.update', $project->id) }}" method="POST" accept-charset="UTF-8">
                    <input type="hidden" name="_method" value="PUT">
            @else
                    <form action="{{ route('project.store') }}" method="POST" accept-charset="UTF-8">
            @endif

            {{ csrf_field() }}

            <div class="form-group">
              <label for="village">村别</label>
              <input type="text" name=" village" class="form-control" value={{ $project->village->name }}>
            </div>

            <input type="hidden" name="id" value={{ $project->id }}>
            <input type="hidden" name="village_id" value={{ $project->village_id }}>

            <div class="form-group">
              <label for="year">年份：</label>
              <input type="text" name="year" class="form-control" value={{ $project->year }}>
            </div>

            <div class="form-group">
              <label for="category">项目类别:</label>
              <input type="text" name="category" class="form-control" value={{ $project->category }}>
            </div>

            <div class="form-group">
              <label for="name"><font color="red">项目名称:</font></label>
              <input type="text" name="name" class="form-control" value={{ $project->name }}>

            </div>
            <div class="form-group">
              <label for="bidprice">中标金额：</label>
              <input type="text" name="bidprice" class="form-control" value={{ $project->bidprice }}>
            </div>
            <div class="form-group">
              <label for="contractprice">合同金额：</label>
              <input type="text" name="contractprice" class="form-control" value={{ $project->contractprice }}>
            </div>
            <div class="form-group">
              <label for="budget">预算金额：</label>
              <input type="text" name="budget" class="form-control" value={{ $project->budget }}>
            </div>
            <div class="form-group">
              <label for="settlementprice">决算金额：</label>
              <input type="text" name="settlementprice" class="form-control" value={{ $project->settlementprice }}>
            </div>

            <div class="form-group">
              <label for="describe"><font color="black">描述：</font></label>
              <textarea type="textarea" name="describe" class="form-control" rows="10" >{{ $project->describe }}</textarea>
            </div>

            <button type="submit" class="btn btn-block btn-success">更新</button>
        </form>
    </div>
  </div>
</div>
@stop