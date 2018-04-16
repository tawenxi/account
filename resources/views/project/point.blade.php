@extends('layouts.default')
@section('title', '更新个人资料')

@section('content')
<div class="offset-md-2 col-md-8">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h1>绑定支付令到项目</h1>
    </div>
    <div class="panel-heading">
      <div class="alert alert-info">
       {{ $zfpz->SKR }}
      </div>
      <div class="alert alert-info">
       {{ $zfpz->SKZH }}
      </div>
      <div class="alert alert-info">
       {{ $zfpz->SKRKHYH }}
      </div>
    </div>
      <div class="panel-body">

        @include('shared.errors')

        <div class="gravatar_edit">
          <a href="http://gravatar.com/emails" target="_blank">
            <img src="" alt="" class="gravatar"/>
          </a>
        </div>

          <form action="{{ route('project.point') }}" method="POST" accept-charset="UTF-8">
                    <input type="hidden" name="_method" value="PUT">

            {{ csrf_field() }}
            <div class="form-group">
              <label for="ZBID">指标是ID</label>
              <input type="text" name=" ZBID" class="form-control" value={{ $zfpz->zb->ZBID }}>
            </div>

            <input type="hidden" name="id" value={{ $zfpz->id }}>

            <div class="form-group">
              <label for="year">年份：</label>
              <input type="text" name="year" class="form-control" value={{ $zfpz->KJND }}>
            </div>

            <div class="form-group">
              <label for="SKZH">银行账号：</label>
              <input type="text" name="SKZH" class="form-control" value={{ $zfpz->SKZH }}>
            </div>

            <div class="form-group">
              <label for="MXZBWH">指标文号:</label>
              <input type="text" name="MXZBWH" class="form-control" value={{ $zfpz->MXZBWH }}>
            </div>

            <div class="form-group">
              <label for="ZY"><font color="red">摘要:</font></label>
              <input type="text" name="ZY" class="form-control" value={{ $zfpz->ZY }}>

            </div>

            <div class="form-group">
              <label for="YSKMQC"><font color="red">预算科目全称:</font></label>
              <input type="text" name="YSKMQC" class="form-control" value={{ $zfpz->YSKMQC }}>
            </div>
            <div class="form-group">
              <label for="YSDWQC"><font color="red">预算单位全称:</font></label>
              <input type="text" name="YSDWQC" class="form-control" value={{ $zfpz->YSDWQC }}>

            </div>

            <div class="form-group">
              <label for="total_amount">指标总金额：</label>
              <input type="text" name="total_amount" class="form-control" value={{ $zfpz->JE }}>
            </div>
            <div class="form-group">
              <label for="already_divided" class="alert-danger">绑定支付令到项目项目：</label>
              <label for="already_divided" class="alert-success"> {{ isset( $zfpz->project->name )? $zfpz->project->name :"" }} </label>
              <select name="project_id" class="form-control">

                <option value="0">无项目</option>
                @foreach ($projects as $project)
                  <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach

              </select>
            </div>

            <div class="form-group">
                <label for="fail">支付失败：</label>
                <input type="text" name="fail" class="form-control" value={{ $zfpz->fail }}>
            </div>

            <div class="form-group">
                <label for="describe">备注：</label>
                <textarea name="describe" id="describe" class="form-control">{{ $zfpz->beizhu }}</textarea>
            </div>
            <button type="submit" class="btn btn-block btn-success">更新</button>
        </form>
        
    </div>




  </div>
</div>
@stop