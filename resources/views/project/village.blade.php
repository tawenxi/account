@extends('layouts.default')
@section('content')
<h1>左安镇扶贫资金明细表({{ $villages->count() }}条数据)</h1>
@include('shared.errors')

<article>
	
	<div class='h4 row'>
		<table class="table table-bordered table-striped table-hover table-condensed table-sm table-dark">
			<caption>
				<center>{{ date("Y-m-d H:i:s") }}</center>
			</caption>
			<thead>
				<tr class='bg-primary'>
				<th>ID</th>
				<th>村别</th>
				<th>年份</th>

				<th>资金来源</th>
				<th>已付资金</th>
				<th>拨付率</th>

				</tr>
			</thead>
			<tbody class='table-hover'>
				@foreach ($villages as $village)
					<tr class='alert-default'>
						<td>{{ $loop->index+1 }}</td>
						<td><a href="/project?village={{ $village->id }}">
							{{ $village->name }}
							</a>

							<a href="/project/tozfl/{{ $village->name }}"  class="btn btn-success">
							支付令
							</a>
						</td>
						<td>{{$village->year}}</td>
						<td>{{ $income_save = $village->projects->sum(function($item){
									return $item->zbs->sum(function($it){
									return $it->pivot->amount;
								});}) }}
						</td>
						<td>
							{{ $payout_save = $village->projects->sum(function($item){
								return $item->zfpzs->sum('JE');
							}) }}
						</td>
						<td>{{ $income_save?div($payout_save/$income_save):'错误' }}</td>
					</tr>	
				@endforeach
			</tbody>
			
				<tr class='bg-primary'>
				<th>ID</th>
				<th>村别</th>
				<th>年份</th>

				<th>资金来源</th>
				<th>已付资金</th>
				<th>拨付率</th>
				</tr>
			
		</table>
		<hr>
	</div>
</article>
@stop