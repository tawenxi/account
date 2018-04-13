@inject('account', 'App\Services\Account')
@extends('layouts.default')
@section('title', '更新个人资料')

@section('content')
      <h1>更新ACCOUNT数据</h1>
      <hr>
      <div class="col-md-8 offset-md-2">
        <div class="panel-body">
          @include('shared.errors')
        {!! Form::model($result,['method' => 'PATCH', 'url' => ['zbdetail/update'], 'class' => 'form-horizontal']) !!}
          {{ csrf_field() }}

          <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
               {!! Form::label('id', 'ID') !!}
               {!! Form::text('id',$result->id, ['class' => 'form-control', 'required' => 'required']) !!}
               <small class="text-danger">{{ $errors->first('id') }}</small>
           </div>

           <div class="form-group{{ $errors->has('QS_RQ') ? ' has-error' : '' }}">
               {!! Form::label('QS_RQ', '清算日期') !!}
               {!! Form::text('QS_RQ',$result->QS_RQ, ['class' => 'form-control']) !!}
               <small class="text-danger">{{ $errors->first('QS_RQ') }}</small>
           </div>

           <div class="form-group{{ $errors->has('zy') ? ' has-error' : '' }}">
               {!! Form::label('zy', '摘要') !!}
               {!! Form::text('zy', $result->ZY, ['class' => 'form-control', 'required' => 'required']) !!}
               <small class="text-danger">{{ $errors->first('zy') }}</small>
           </div>

           <div class="form-group{{ $errors->has('JE') ? ' has-error' : '' }}">
               {!! Form::label('JE', '金额') !!}
               {!! Form::text('JE',$result->JE, ['class' => 'form-control', 'required' => 'required']) !!}
               <small class="text-danger">{{ $errors->first('JE') }}</small>
           </div>

                 <tr>
        <td colspan="7">
          {!! Form::label('请输入科目', \DB::table('accounts')->where('account_number',$result->account_number)->value('account_name')) !!}
        <input type="hidden" name="">
                 {!! csrf_field() !!}       
          <div class="form-group">
              <vselect :account={{ $account->getAccount() }} ></vselect>
          </div>
      </td></tr>

               <button type="submit" class="btn btn-block btn-success">更新</button>
       {!! Form::close() !!}
    </div>
      </div>
@stop