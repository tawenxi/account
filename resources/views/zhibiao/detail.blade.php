@extends('layouts.default')
@section('content')
<h1>左安镇指标支出所有明细表({{ $results->count().'条' }})</h1>
@include('shared.errors')

<article>
	
	<div  class='h4 row'>
	<table class="table table-bordered table-striped table-hover table-condensed">
		<caption>
			<center>{{ date("Y-m-d H:i:s") }}</center>
		</caption>

		<thead>
			<tr class='success'>
				<th>isd</th>
				<th>支出ID</th>
				<th>ZBID</th>
				<th>日期</th>
				<th>摘要</th>
				<th>收款人</th>
				<th>预算单位</th>
				<th>总金额</th>
				<th>支出类型</th>
				@receive<th>received</th>@endreceive
			</tr>
		</thead>
		<tbody class='alert-info'>
			@foreach ($results as $result)
				<tr>
			 		<td>
			 			{{ $loop->index+1 }}
			 		</td>
					<td class="col-md-2 small">
						<a href="{{ route('zbdetail.edit',['id'=>$result->id]) }}">
							@if (!is_null($result->account))
								{{$result->account->name}} 
							@endif
						</a>
					</td>
					<td>
						<a href="/showzbdetail/{{ $result->ZBID }}">{{substr($result->ZBID, 11)}}</a> 
					</td>
					<td>
						{{$result->QS_RQ}} 
					</td>
					<td>
						<a href="/point/{{$result->id}}">
							{{$result->ZY}}
						</a>
					</td>
					<td >
						<h4>{{$result->SKR}}</h4>
					</td>
					<td>
						{{ substr($result->YSDWMC, 9) }}
					</td>
					<td>
						{{div($result->JE)}}
					</td>
					<td>
						{{ substr($result->ZFFSMC, 0,3) }}
					</td>	
					@receive
						<td>
							<received :zfpz = {{ $result->id }} ></received>
						</td>
					@endreceive

				</tr>	
			@endforeach
		</tbody>
		<tr class='success'>
			<th>id</th>
			<th>支出ID</th>
			<th>ZBID</th>
			<th>日期</th>
			<th>摘要</th>
			<th>收款人</th>
			<th>预算单位</th>
			<th>{{($results->sum('JE'))/10000}}</th>
			<th>支出类型</th>
			@receive<th>received</th>@endreceive
		</tr>
	</table>
			<hr>
	</div>
</article>
@stop

@section('js')
	<script>
	Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name=csrf-token]').getAttribute('content')
	</script>
@stop