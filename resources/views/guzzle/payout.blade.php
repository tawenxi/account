@extends('layouts.default')
@section('content')
<h1>枚江乡授权支付支出明细表</h1>
@include('shared.errors')
<article>
	<h2>
	<table class="table table-bordered table-striped table-hover table-condensed table-sm table-dark">
		<caption><center>{{ date("Y-m-d H:i:s") }}</center></caption>
		{!! Form::open(['method' => 'POST', 'route' => 'payout', 'class' => 'form-horizontal']) !!}
		    <div class="form-group{{ $errors->has('date1') ? ' has-error' : '' }}">
		        {!! Form::label('date', '开始日期(my参数可以控制page)') !!}
		        {!! Form::date('date1', date('Y-m-01',time()), ['class' => 'form-control', 'required' => 'required']) !!}
		        <small class="text-danger">{{ $errors->first('date') }}</small>
		    </div>
		    		    <div class="form-group{{ $errors->has('date2') ? ' has-error' : '' }}">
		        {!! Form::label('date', '结束日期(order控制排序方式)') !!}
		        {!! Form::date('date2', date('Y-m-d',time()+86400), ['class' => 'form-control', 'required' => 'required']) !!}
		        <small class="text-danger">{{ $errors->first('date') }}</small>
		    </div>
		    <div class="form-group{{ $errors->has('order') ? ' has-error' : '' }}">
		        {!! Form::label('order', '排序（默认按时间排序，默认时间为本月）') !!}
		        {!! Form::select('order', ['created_at'=>"时间",'kemuname'=>"科目",'amount'=>"金额"], ['id' => 'order', 'class' => 'form-control', 'required' => 'required', 'multiple']) !!}
		        <small class="text-danger">{{ $errors->first('order') }}</small>
		    </div>    
		        {!! Form::submit("查询", ['class' => 'btn btn-block btn-success ']) !!}
		   	
	        	{!! Form::close() !!}

		<thead>
			<tr class='bg-primary'>
				<th>时间</th><th>摘要</th><th>收款人</th><th>金额</th><th>科目</th><th>指标ID</th>
			<th>T</th><th>D</th></tr>
		</thead>
		<tbody class='table-hover'>
				@foreach ($payoutdatas as $payoutdata)
			<tr>
				<td>			
					{{substr($payoutdata->created_at, 0,10)}}			
				</td>

				<td>
				
					<a href= {{ route('editkemu',$payoutdata->id)  }} ><font style="color:green">{{$payoutdata->zhaiyao}}</font></a>
				
				</td>
				<td>
					{{$payoutdata->payee}}</td>
				<td>{{$payoutdata->amount}}</td>
				<td>{{  substr($payoutdata->kemuname, 1+strpos($payoutdata->kemuname, "@"))}}</td>
				<td>{{substr($payoutdata->zbid, -4)}}</td>
				<td><font style="font-size: 2px " >{{  substr($payoutdata->kemuname, 0,strpos($payoutdata->kemuname, "@"))}}&
				{{ $payoutdata->zhaiyao }}&
				{{ $payoutdata->amount }}&
				1001&001</font></td>
				<td><form action="{{ route('delete', $payoutdata->id) }}" method="post">
        {{ csrf_field() }}
        {{ method_field('DELETE') }}
        <button type="submit" class="btn btn-sm btn-danger delete-btn">删除</button>
      </form></td>
			</tr>	
			@endforeach
		</tbody>
	{!! $payoutdatas->appends(['order' => $a,'my' => $my,'date1'=>$date1,'date2'=>$date2])->render() !!}

	</table>
			<hr>
	
	</h2>
</article>
{{-- {!! Form::open() !!}
 {!! Form::text("name") !!}
{!! Form::close() !!} --}}
@stop