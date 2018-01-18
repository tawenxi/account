@extends('layouts.default')
@section('content')
<h1>左安镇指标明细表({{ $results->count().'条' }})</h1>
@include('shared.errors')

<article>
	
	<row class='h4'>
		<table class="table table-bordered table-striped table-hover table-condensed">
			<caption>
				<center>{{ date("Y-m-d H:i:s") }}</center>
			</caption>

			<thead>
				<tr class='success'>
				 	<th>id</th>
					{{-- <th>科目</th> --}}
					<th>指标ID</th>
					<th>日期</th>
					<th>摘要</th>
					{{-- 	<th>指标来源</th> --}}
					<th>预算项目</th>
					<th>总金额</th>
					<th>可用金额</th>
					<th>支出数</th>
					<th>单位</th>
				</tr>
			</thead>
			<tbody class='alert-info'>
				@foreach ($results as $result)
					<tr class={{ abs($result->JE-$result->zfpzs->sum('JE'))<1?'alert-danger':""}}>
					   	<td>{{ $loop->index+1 }}</td>					
						<td class="small">
							<a href="/showzbdetail/{{ $result->ZBID }}">{{$result->ZBID}} 
							</a>
						</td>
						<td>{{$result->LR_RQ}}</td>
						<td class="col-md-3">{{$result->ZY}}</td>
						<td>{{substr($result->ZJXZMC,0,12)}}</td>
						<td>{{$result->JE}}</td>
						<td>{{div($result->yeamount)}}</td>
						<td >{{ $result->zfpzs->count() }}</td>
						<td class="">{{ substr($result->YSDWMC, 9) }}</td>
					</tr>	
				@endforeach
			</tbody>
				<tr class='success'>
					<th>id</th>
					<th>指标ID</th>
					<th>日期</th>
					<th>摘要</th>
					<th>预算项目</th>
					<th>{{round($results->sum('JE')/10000,2)}}</th>
					<th>{{round(round(($results->sum('JE'))/10000,2)-round($results->sum('detail')/10000,2),2)}}</th>
					<th>支出数</th>
					<th>单位</th>
				</tr>
		</table>
		<hr>	
	</row class='h4'>
</article>
@stop