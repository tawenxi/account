@extends('layouts.default')
@section('content')
<h1>左安镇支出数概览!({{ $results->count().'条' }})</h1>
@include('shared.errors')

<article>
	
	<div class='h4'>
		<table class="table table-dark table-bordered table-striped table-hover table-condensed table-sm">
			<caption>
				<center>{{ date("Y-m-d H:i:s") }}</center>
			</caption>

			<thead>
				<tr class='bg-primary'>
					<th><h6>id</h6></th>
					<th><h6>期间</h6></th>
					<th><h6>收入数量</h6></th>
					<th><h6>收入金额</h6></th>
					<th><h6>支出数量</h6></th>
					<th><h6>支出金额</h6></th>
					<th><h6>净流量</h6></th>

				</tr>
			</thead>
			<tbody class='table-hover'>
				@foreach ($results as $result)
					<tr>
					   	<td>{{ $loop->index+1 }}</td>
					   	<td>{{ $result->peroid }}</td>

					   	<td>{{ $datas->where('peroid',$result->peroid)->first()?$datas->where('peroid',$result->peroid)->first()->count:'' }}</td>
					   	<td>{{ $income = $datas->where('peroid',$result->peroid)->first()?$datas->where('peroid',$result->peroid)->first()->amount/10000:'0' }}</td>
					   	<td>{{ $result->count }}</td>
					   	<td>{{ $cost = $result->amount/10000 }}</td>
					   	<td>{{ $income-$cost }}</td>
					</tr>	
				@endforeach
			</tbody>
				<tr class='bg-primary'>
					<th><h6>id</h6></th>
					<th><h6>期间</h6></th>
					<th><h6>收入数量</h6></th>
					<th><h6>收入金额</h6></th>
					<th><h6>支出数量</h6></th>
					<th><h6>支出金额</h6></th>
					<th><h6>净流量</h6></th>

				</tr>
		</table>
		<hr>	
	</div>
</article>
@stop