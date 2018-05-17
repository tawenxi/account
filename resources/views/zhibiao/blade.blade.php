@extends('layouts.default')
@section('content')
<h1>左安镇授权支付指标明细表({{ $results->count() }}条数据)</h1>
@include('shared.errors')

<article>
	
	<div class='h4'>
		<table class="table table-bordered table-striped table-hover table-dark table-sm">
			<caption>
				<center>{{ date("Y-m-d H:i:s") }}</center>
			</caption>
			<thead>
				<tr class="table-hover">
				<th>行号</th>
				<th>摘要</th>
				<th>科目代码</th>
				<th>借贷</th>
				<th>金额</th>
				<th>日期</th>
				<th>凭证编号</th>
				<th>期间</th>
				</tr>
			</thead>
			<tbody class='table-hover'>
				@foreach ($results as $result)
					<tr>
						<td>{{ $result['hanghao'] }}</td>
						<td>
							<h6>{{$result['ZY']}}</h6>
							
						</td>
						<td><h5>{{$result['account_number']}}</h5></td>
						<td><h5>借</h5></td>
						<td>{{div($result['JE']/100)}}</td>
						<td >{{ $request['rq'] }}</td>
						<td>{{ $result['list_id'] }}</td>
						<td >{{ $request['qj'] }}</td>
					</tr>	
				@endforeach
			</tbody>
				<tr class="table-hover">
					<th>行号</th>
					<th>摘要</th>
					<th>科目代码</th>
					<th>借贷</th>
					<th>{{ div($results->sum('JE')/100) }}</th>
					<th>日期</th>
					<th>凭证编号</th>
					<th>期间</th>
				</tr>
		</table>
		<hr>
	</div>
</article>
@stop