@extends('layouts.default')
@section('content')
<h1>左安镇可用支付申请明细表({{ $results->count().'条' }})</h1>
@include('shared.errors')

<article>
	<h2>
	<table class="table table-bordered table-striped table-hover table-condensed table-sm table-dark">
		<caption><center>{{ date("Y-m-d H:i:s") }}</center></caption>

		<thead>
			<tr class='bg-primary'>
				<th>id</th>
				<th class="text-center">zbid</th>
				<th>预算单位</th>
				<th>项目名称</th>
				<th class="text-center">摘要</th>
				<th>ZB总额</th>
				<th>已申请金额</th>
				<th>剩余申请额</th>
				<th>剩余ZF金额</th>
			</tr>
		</thead>
		<tbody class='table-hover'>
				@foreach ($results as $result)
			<tr>


			 	<td>{{ $loop->index+1 }}</td>
				<td>{{$result->ZBID}} </td>
				<td >{{ substr($result->YSDWMC, 9) }}</td>
				<td>{{$result->XMMC}} </td>
				<td >{{$result->ZY}}</td>
				<td >{{$result->ZBJE}}</td>
				<td >{{$result->YFPJE}}</td>
				<td>{{$result->ZBYE}}</td>
				<td>{{$result->KYJHJE}}</td>
			</tr>	
			@endforeach
		</tbody>
			<tr class='bg-primary'>
				<th>id</th>
				<th>zbid</th>
				<th>预算单位</th>
				<th>项目名称</th>
				<th class="text-center">摘要</th>
				<th >{{$results->sum('ZBJE')}}</th>
				<th >{{$results->sum('YFPJE')}}</th>
				<th>{{$results->sum('ZBYE')}}</th>
				<th>{{$results->sum('KYJHJE')}}</th>
			</tr>
	</table>
			<hr>
	</h2>
</article>
@stop