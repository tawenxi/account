@extends('layouts.default')
@section('content')
<h1>左安镇直接支付指标明细表({{ $results->count() }}条数据)</h1>
@include('shared.errors')

<article>
	
	<div class='h4'>
		<table class="table table-dark table-bordered table-striped table-hover table-condensed table-sm">
			<caption>
				<center>{{ date("Y-m-d H:i:s") }}</center>
			</caption>
			<thead>
				<tr class='bg-primary'>
				<th>ID</th>
				<th>指标ID</th>
				<th>摘要</th>
				<th>预算项目</th>
				<th>总金额</th>
				<th>可用金额</th>
				</tr>
			</thead>
			<tbody class='table-hover'>
				@foreach ($results as $result)
					<tr >
						<td>{{ $loop->index+1 }}</td>
						<td>
							<a class="badge badge-primary" href="{{ $result->ZBID }}/show">{{$result->ZBID}}
							</a>
						</td>
						<td><h6>{{$result->ZY}}</h6></td>
						<td><h6>{{$result->ZJXZMC}}</h6></td>
						<td>{{$result->YKJHZB}}</td>
						<td>{{$result->KYJHJE}}</td>
				
					</tr>	
				@endforeach
			</tbody>
				<tr class='bg-primary'>
					<th>ID</th>
					<th>指标ID</th>
					<th>摘要</th>
					<th>预算项目</th>
					<th>{{div(($results->sum('YKJHZB'))/10000)}}</th>
					<th>{{div($results->sum('KYJHJE')/10000)}}</th>
				</tr>
		</table>
		<hr>
	</div>
</article>
@stop