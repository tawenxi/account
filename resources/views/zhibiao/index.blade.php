@extends('layouts.default')
@section('content')
<h1>左安镇指标明细表!({{ $results->count().'条' }})</h1>
@include('shared.errors')

<article>
	
	<div class='h4'>
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
					@if (strstr(url()->full(),'%3A%E6%89%B6%E8%B4%AB'))
						<th>已分配</th>
					@endif
					
					<th>支出数</th>
					<th>已分配</th>
					<th>单位</th>
					<th>可用性</th>
				</tr>
			</thead>
			<tbody class='alert-info'>
				@foreach ($results as $result)
					<tr class={{ ($divider = $result->projects->sum(function($item){
					                                return $item->pivot->amount;
					                           })>0)?'alert-warning':(abs($result->JE-$result->zfpzs->sum('JE'))<1?'alert-danger':"") }}>
					   	<td>{{ $loop->index+1 }}</td>					
						<td class="small">
							<a href="/showzbdetail/{{ $result->ZBID }}">{{$result->ZBID}} 
							</a>
						</td>
						<td>{{$result->LR_RQ}}</td>
						<td class="col-md-3" >
							@if ($result->beizhu)
								<button type="submit" title="{{$result->zb?$result->zb->ZY:'' }}" class="btn btn-primary btn-sm">备注</button>
								<a href="/divider/{{ $result->id }}" title="{{$result->beizhu?$result->beizhu:'' }}" >
							@endif
							{{$result->ZY}}
							@if ($result->beizhu)
								</a>
							@endif

						</td>
						<td>{{substr($result->ZJXZMC,0,12)}}</td>
						<td>{{$result->JE}}</td>
						<td>{{div($result->yeamount)}}</td>
						@if (strstr(url()->full(),'%3A%E6%89%B6%E8%B4%AB'))
							<td> {{ $result->projects->sum(function($item){
	                                return $item->pivot->amount;
	                           }) }}
	                       </td>
	                    @endif

						<td >{{ $result->zfpzs->count() }}</td>
						<td >{{ $result->projects->sum(function($item){
                                return $item->pivot->amount;
                           }) }}</td>
						
						{{-- @if (strstr($result->YSDWMC,'扶贫')) --}}
							<td class="btn btn-block btn-success "><a href="{{ strstr($result->YSDWMC,'扶贫')?"/divider/$result->id":"/divider/$result->id" }}" >
				{{-- 		@else
							<td >
						@endif --}}
						
				{{-- 		@if (strstr($result->YSDWMC,'扶贫')) --}}
						<font class="text-danger">{{ substr($result->YSDWMC, 9) }}</font>
							</a>
{{-- 						@else
						{{ substr($result->YSDWMC, 9) }}
						@endif --}}
					</td>
					<td >
						@if ($result->KYX)
							<button type="submit" class="btn btn-primary btn-sm">可用</button>
						@else
							<button type="submit" class="btn btn-danger btn-sm">不可用</button>
						@endif
					</td>
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
					@if (strstr(url()->full(),'%3A%E6%89%B6%E8%B4%AB'))
						<th>已分配</th>
					@endif
					<th>支出数</th>
					<th>已分配</th>
					<th>单位</th>
					<th>可用性</th>
				</tr>
		</table>
		<hr>	
	</div>
</article>
@stop