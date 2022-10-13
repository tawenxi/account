@extends('layouts.default')
@section('content')
<h1>左安镇指标明细表({{ $zbs->count().'条' }})</h1>
@include('shared.errors')

<article>
	
	<div class='h4 row'>
		<table class="table table-dark table-bordered table-striped table-hover table-condensed table-sm">
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
					<th>分配金额</th>
					<th>支出数</th>
					<th>单位</th>
				</tr>
			</thead>
			<tbody class='table-hover'>
				@foreach ($zbs as $result)
					<tr class={{ abs($result->JE-$result->zfpzs->sum('JE'))<1?'alert-danger':""}}>
					   	<td>{{ $loop->index+1 }}</td>					
						<td class="small">
							<a href="/showzbdetail/{{ $result->ZBID }}">{{$result->ZBID}} 
							</a>
						</td>
						<td>{{$result->LR_RQ}}</td>
						<td class="col-md-3"><a href="/es?q={{ '@'.$result->ZY }}" class="btn  btn-success">{{$result->ZY}}</a></td>
						<td>{{substr($result->ZJXZMC,0,12)}}</td>
						<td>{{$result->JE}}</td>
						<td>{{div($result->yeamount)}}</td>

						<td class="alert-success">{{div($result->pivot->amount)}}</td>

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
					<th>{{round($zbs->sum('JE')/10000,2)}}</th>
					<th>{{round(round(($zbs->sum('JE'))/10000,2)-round($zbs->sum('detail')/10000,2),2)}}</th>
					<th>分配金额</th>
					<th>支出数</th>
					<th>单位</th>
				</tr>
		</table>
		<hr>	
	</div>
</article>
@stop