@extends('layouts.default')
@section('title', '更新个人资料')

@section('content')
<div class="offset-md-2 col-md-8">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h1>分配指标数据</h1>
    </div>
      <div class="panel-body">

        @include('shared.errors')

        <div class="gravatar_edit">
          <a href="http://gravatar.com/emails" target="_blank">
            <img src="" alt="" class="gravatar"/>
          </a>
        </div>

          <form action="{{ route('project.divider') }}" method="POST" accept-charset="UTF-8">
                    <input type="hidden" name="_method" value="PUT">

            {{ csrf_field() }}

            <div class="form-group">
              <label for="ZBID">指标是ID</label>
              <input type="text" name=" ZBID" class="form-control" value={{ $zb->ZBID }}>
            </div>

            <input type="hidden" name="id" value={{ $zb->id }}>

            <div class="form-group">
              <label for="year">年份：</label>
              <input type="text" name="year" class="form-control" value={{ $zb->KJND }}>
            </div>

            <div class="form-group">
              <label for="MXZBWH">指标文号:</label>
              <input type="text" name="MXZBWH" class="form-control" value={{ $zb->MXZBWH }}>
            </div>

            <div class="form-group">
              <label for="ZY"><font color="red">摘要:</font></label>
              <input type="text" name="ZY" class="form-control" value={{ $zb->ZY }}>

            </div>

            <div class="form-group">
              <label for="YSKMQC"><font color="red">预算科目全称:</font></label>
              <input type="text" name="YSKMQC" class="form-control" value={{ $zb->YSKMQC }}>

            </div>

            <div class="form-group">
              <label for="YSDWQC"><font color="red">预算单位全称:</font></label>
              <input type="text" name="YSDWQC" class="form-control" value={{ $zb->YSDWQC }}>

            </div>


            <div class="form-group">
              <label for="total_amount">指标总金额：</label>
              <input type="text" name="total_amount" class="form-control" value={{ $zb->JE }}>
            </div>

            <div class="form-group">
              <label for="already_divided">已分配金额：</label>
              <input type="text" name="already_divided" class="form-control" 
                     value={{ $zb->projects->sum(function($item){
                                return $item->pivot->amount;
                           }) }}>
            </div>
            <div class="form-group">
              <label for="already_divided" class="text-success">剩余分配金额：</label>
              <input type="text"  class="form-control" 
                     value={{ $zb->JE - $zb->projects->sum(function($item){
                                return $item->pivot->amount;
                           }) }}>
            </div>

            <div class="form-group">
              <label for="KYX" class="text-success">可用性：</label>
              <input type="text"  class="form-control" name="KYX" 
                     value={{ $zb->KYX }}>
            </div>

            <div class="form-group">
              <label for="beizhu" class="text-success">备注：</label>
              <input type="text"  class="form-control" name="beizhu" 
                     value={{ $zb->beizhu }}>
            </div>

            <div class="form-group">
              <label for="already_divided">分配金额到项目：</label>
              <select name="project_id" class="form-control" >
                @foreach ($projects as $project)
                  <option value="{{ $project->id }}">{{ $project->name }}</option>
                @endforeach

              </select>
            </div>

            <div class="form-group">
              <label for="amount">分配指标金额：</label>
              <input type="text" name="amount" class="form-control" value="0"required="true">
            </div>

            

            <button type="submit" class="btn btn-block btn-success">更新</button>
        </form>



        <div class="form-group">
              <label for="describe"><font color="black">已分配到项目：</font></label>
              <br>
              <a class="btn btn-primary" href="/divider/{{ $zb->transforToOrigin()->id }}">{{ $zb->transforToOrigin()->ZBID }}</a>
              @if ($zb->isOriginZb())
                <button type="submit" class="btn btn-success">是原始指标</button>
              @else
                <button type="submit" class="btn btn-danger">不是原始指标</button>
              @endif
              <table class="table table-bordered table-striped table-hover table-dark table-sm">
                <thead>
                  <tr>
                    <th>项目</th><th>金额</th><th>ZBID</th><th>删除</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($zb->transforToOrigin()->projects as $project)
                    <tr>
                    <td class="col-md-4">{{ $project->name }}</td>
                    <td>{{ $project->pivot->amount }}</td>
                    <td>
                      <a href="/sourcezb/{{ $zb->ZBID }}" class="btn btn-success btn-sm">
                      {{ $zb->transforToOrigin()->ZBID }}
                      </a>
                    </td>
                    <td class="col-md-1">
                        {!! Form::open(['method' => 'post',  'route' => ['project.deletezb'],'class' => 'form-horizontal']) !!}
                        <input type="hidden" name="project_id" value={{ $project->id }}>
                        <input type="hidden" name="zb_id" value={{ $zb->id }}>
                        <input type="hidden" name="amount" value={{ $project->pivot->amount }}>


                        {!! Form::submit('删除', ['class' => 'btn btn-danger pull-right btn-sm']) !!}
            
                        {!! Form::close() !!}
                    </td>

                    </tr>
                  @endforeach
                  
                </tbody>
              </table>


              <table class="table table-bordered table-striped table-hover table-dark table-sm">
                <thead>
                  <tr>
                    <th>项目</th><th>金额</th><th>ZBID</th><th>删除</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($zb->projects as $project)
                    <tr>
                    <td class="col-md-4">{{ $project->name }}</td>
                    <td>{{ $project->pivot->amount }}</td>
                    <td>
                      <a href="/sourcezb/{{ $zb->ZBID }}" class="btn btn-success btn-sm">
                      {{ $zb->transforToOrigin()->ZBID }}
                      </a>
                    </td>
                    <td class="col-md-1">
                        {!! Form::open(['method' => 'post',  'route' => ['project.deletezb'],'class' => 'form-horizontal']) !!}
                        <input type="hidden" name="project_id" value={{ $project->id }}>
                        <input type="hidden" name="zb_id" value={{ $zb->id }}>
                        <input type="hidden" name="amount" value={{ $project->pivot->amount }}>


                        {!! Form::submit('删除', ['class' => 'btn btn-danger pull-right btn-sm']) !!}
            
                        {!! Form::close() !!}
                    </td>

                    </tr>
                  @endforeach
                  
                </tbody>
              </table>
            </div>
    </div>




  </div>
</div>
@stop