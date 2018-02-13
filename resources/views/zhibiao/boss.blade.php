
@extends('layouts.default')
@section('content')
<h1>{{ $results->first()->SKR }}({{ $results->count().'条' }})</h1>
@include('shared.errors')

<article>
	<div  class='h4 row'>
	<table class="table table-bordered table-striped table-hover table-condensed">
		<caption>
			<center>{{ date("Y-m-d H:i:s") }}</center>
		</caption>

		<thead>
			<tr class='success'>
				<th>id</th>
				<th>支出ID</th>
				<th class="col-md-1">ZBID</th>
				<th>日期</th>
				<th>摘要</th>
				<th>收款人</th>
				<th>预算单位</th>
				<th>总金额</th>
				<th>支出类型</th>
				<th>received</th>
			</tr>
		</thead>
		<tbody class='alert-info'>
			@foreach ($results as $result)
				<tr>
			 		<td>
			 			{{ $loop->index+1 }}
			 		</td>
					<td class="col-md-2 small">
						
							@if (!is_null($result->account))
								<a href="{{ route('zbdetail.edit',['id'=>$result->id]) }}">
									{{$result->account->name}} 
								</a>
							@else
								<form 	 method="GET"
										 action="{{ route('zbdetail.edit',['id'=>$result->id]) }}" 
										 enctype="multipart/form-data">
									<button type="submit" class="btn btn-success center-block">编辑科目</button>
								</form>
								
							@endif
						
					</td>
					<td class="small initialism">
						<a href="/showzbdetail/{{ $result->ZBID }}" title="{{$result->zb?$result->zb->ZY:'' }}" >{{$result->zb->ZY}}</a> 
					</td>
					<td>{{$result->QS_RQ}}</td>
					<td>
						<a href="/point/{{$result->id}}">
							{{$result->ZY}}
						</a>
					</td>
					<td >
						<h4>{{$result->SKR}}</h4>
					</td>
					<td>{{ substr($result->YSDWMC, 9) }}</td>
					<td>{{div($result->JE)}}</td>
					<td>{{ substr($result->ZFFSMC, 0,3) }}</td>	
					<td>
							<received :zfpz = {{ $result->id }} 
									  :is_received = {{ $result->received }} ></received>
					</td>
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
			<th>received</th>
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