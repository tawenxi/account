@extends('layouts.default')
@section('title', '更新个人资料')

@section('content')
<div class="offset-md-2 col-md-8">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h1>更新指标数据</h1>
    </div>
      <div class="panel-body">

        @include('shared.errors')

        <div class="gravatar_edit">
          <a href="http://gravatar.com/emails" target="_blank">
            <img src="" alt="" class="gravatar"/>
          </a>
        </div>
        <form action="{{ route('project.store') }}" method="POST" accept-charset="UTF-8">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="village_id">分配金额到项目：</label>
              <select  class="form-control" name="village_id" >
                @foreach (\App\Model\Project\Village::all() as $village)
                  <option value="{{ $village->id }}">{{ $village->name }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="year">年份：</label>
              <select  class="form-control" name="year" >
                @foreach (['0','2016','2017','2018'] as $year)
                  <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <label for="category">项目类别:</label>
              <input type="text" name="category" class="form-control" >
            </div>

            <div class="form-group">
              <label for="name"><font color="red">项目名称:</font></label>
              <input type="text" name="name" class="form-control" >

            </div>
            <div class="form-group">
              <label for="bidprice">中标金额：</label>
              <input type="text" name="bidprice" class="form-control" value="0">
            </div>
            <div class="form-group">
              <label for="contractprice">合同金额：</label>
              <input type="text" name="contractprice" class="form-control"  value="0">
            </div>
            <div class="form-group">
              <label for="budget">预算金额：</label>
              <input type="text" name="budget" class="form-control"  value="0">
            </div>
            <div class="form-group">
              <label for="settlementprice">决算金额：</label>
              <input type="text" name="settlementprice" class="form-control"  value="0">
            </div>

            <div class="form-group">
              <label for="describe"><font color="black">描述：</font></label>
              <textarea type="textarea" name="describe" class="form-control" rows="10" ></textarea>
            </div>

            <button type="submit" class="btn btn-block btn-success">更新</button>
        </form>
    </div>
  </div>
</div>
@stop