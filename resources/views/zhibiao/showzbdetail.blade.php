@extends('layouts.default')
@section('content')
<h1>左安镇指标支出明细表({{ count($results).'条' }})</h1>
@include('shared.errors')

<article>
	<h2>
		<table class="table table-bordered table-striped table-hover table-condensed table-sm table-dark">
			<caption><center>{{ date("Y-m-d H:i:s") }}</center></caption>

			<thead>
				<tr class='bg-primary'>
					<th>日期</th>
					<th>摘要</th>
					<th>收款人</th>
					<th>金额</th>
					<th>单位</th>
					<th>项目名称</th>
					<th>支出类别</th>
					<th>XZ</th>
					
				</tr>
			</thead>
			<tbody class='table-hover'>
					@foreach ($results as $result)
				<tr class={{ isset($result->project)?'alert-warning':""}}>
				<td>{{$result->QS_RQ}}</td>
				<td>
					<a href="/point/{{ $result->id }}">{{$result->ZY}}</a>
				</td>
				<td>{{$result->SKR}} </td>

				<td>{{$result->JE}} </td>
				<td>{{$result->YSDWMC}}</td>
				<td>{{$result->XMMC}}</td>
				<td >{{$result->ZFFSMC}}</td>
				<td >{{$result->ZJXZDM}}</td>
				</tr>	
				@endforeach
			</tbody>
			<tr class='bg-primary'>
				<th>日期</th>
				<th>摘要</th>
				<th>收款人</th>
				<th>{{ collect($results)->sum('je') }}</th>
				<th>单位</th>
				<th>项目名称</th>
				<th>支出类别</th>
				<th>XZ</th>
			</tr>
		</table>
		<hr>
	</h2>
</article>
@stop