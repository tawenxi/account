@extends('layouts.default')
@section('content')
<h1>左安镇授权支付指标明细表({{ $results->count() }}条数据)</h1>
@include('shared.errors')

<article>
	
	<div class='h4'>
		<ul class="list-group">
			
				<li class="table-hover">
				<th>行号</th>
				<th>摘要</th>
				<th>科目代码</th>
				<th>借贷</th>
				<th>金额</th>
				<th>日期</th>
				<th>凭证编号</th>
				<th>期间</th>
				</li>
		
			
				@foreach ($results as $result)
					<li>
						<span>{{ $result['hanghao'] }} |</span>
						<span>{{$result['ZY']}} |</span>
						<span>{{$result['account_number']}} |</span>
						<span>借 |</span>
						<span>{{div($result['JE']/100)}} |</span>
						<span >{{ $request['rq'] }} |</span>
						<span>{{ $result['list_id'] }} |</span>
						<span >{{ $request['qj'] }}</span>
					</li>	
				@endforeach
			
				<li class="table-hover">
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