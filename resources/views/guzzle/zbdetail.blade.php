@inject('account', 'App\Services\Account')
@extends('layouts.default')
@section('content')

<br><br><br>
<h1>枚江镇指标支出所有明细表({{ $results->count().'条' }})</h1>
@include('shared.errors')

<article>
	<h2>
	<form action="/storeaccount" method="post">
	{!! csrf_field() !!}
	<table class="table table-bordered table-striped table-hover table-condensed table-sm table-dark">
		<caption><center>{{ date("Y-m-d H:i:s") }}</center></caption>

		<thead>
			<tr class='success'>
				<th>支出ID</th>
				<th>日期</th>
				<th>摘要</th>
				<th>预算单位</th>
				<th>总金额</th>
				<th>支出类型</th>
			
			</tr>
		</thead>
		<tbody class='alert-info'>
	
		
		@foreach ($results as $result)
			<tr>
				<td class="small">
						{{$result->account?
						$result->account->account_name:''}}
				</td>
				<td>{{ $result->QS_RQ }} </td>
				<td>{{$result->ZY}}</td>
				<td>{{$result->YSDWMC}}</td>
				<td>{{$result->JE}}</td>
				<td>{{$result->ZFFSMC}}</td>	
			</tr>
			<tr>
				<td colspan="7" class="btn-success">
				
              			 <Makeaccount :account={{ $account->getAccount() }}
                                  :zfpz={{ $result->PDH }}  
                         ></Makeaccount>
					
			</td></tr>

		@endforeach
		</tbody>
			
			<tr class='success'>
				<th>指标ID</th>
				<th>摘要</th>
				<th>预算项目</th>
				<th></th>
				<th>{{($results->sum('JE'))/10000}}</th>
				<th>支出类型</th>
			</tr>
	</table>
	<button type="submit" class="btn btn-default btn-block">设置科目</button>	
</form>  
			<hr>
	</h2>
</article>
{{-- {!! Form::open() !!}
 {!! Form::text("name") !!}
{!! Form::close() !!} --}}


@stop

