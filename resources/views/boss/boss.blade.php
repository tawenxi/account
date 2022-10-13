@extends('layouts.default')
@section('content')

@if (null !== $results->first())
	<h1>{{ strstr(url()->current(),'tozfl')?filterVillage($results->first()->ZY):$results->first()->SKR }}({{ $results->count().'条' }})</h1>
@endif


@include('shared.errors')

<article>
	<div  class='h4 row'>
	<table class="table table-bordered table-striped table-hover table-condensed table-dark table-sm">
		<caption>
			<center>{{ date("Y-m-d H:i:s") }}</center>
		</caption>

		<thead>
			<tr class='bg-primary'>
				<th><h6>id</h6></th>
				<th><h6>支出ID</h6></th>
				<th><h6>ZBID</h6></th>
				<th><h6>日期</h6></th>
				<th><h6>摘要</h6></th>
				<th><h6>收款人</h6></th>
				<th><h6>预算单位</h6></th>
				<th><h6>总金额</h6></th>
				<th><h6>支出类型</h6></th>
				<th><h6>项目村</h6></th>
				<th><h6>received</h6></th>
			</tr>
		</thead>
		<tbody class='table-hover'>
			@foreach ($results as $result)
				<tr v-show="isHiddenMe({{ $result->id }})" class={{ isset($result->project)?'bg-warning':""}}>
			 		<td v-bind:class="{'btn btn-danger': isColorMe({{ $result->id }})}" 
			 			@click=colored({{ $result->id }})>
			 			{{ $loop->index+1 }} 
			 		</td>
					<td class="small">
						
							@if (!is_null($result->account))
								<a href="{{ route('zbdetail.edit',['id'=>$result->id]) }}" title="{{ $result->account->name }}">
									{{-- <h6>{{$result->account->name}} </h6> --}}
									<h6>{{substr($result->account->name,0,1+strrpos($result->account->name,'@')).substr($result->account->name,1+strrpos($result->account->name,'-'))}} </h6>
								</a>
							@else
								<form 	 method="GET"
										 action="{{ route('zbdetail.edit',['id'=>$result->id]) }}" 
										 enctype="multipart/form-data">
									<button type="submit" class="btn btn-success center-block">编辑</button>
								</form>
								
							@endif
						
					</td>
					<td class="small initialism">
						<h6>
							<a href="/showzbdetail/{{ $result->ZBID }}" title="{{$result->zb?$result->zb->ZY:'' }}" >{{$result->zb->ZY}}</a> 
						</h6>
					</td>
					<td><h6>{{$result->QS_RQ}}</h6></td>
					<td>
						<a href="/point/{{$result->id}}" title="{{ $result->beizhu }}">
							@if ($result->beizhu)
								<button type="submit" class="btn btn-primary btn-sm">备注</button>
							@endif
							<h6>{{$result->ZY}}</h6>
						</a>
					</td>
					<td >
						<h4><a href="/{{$result->SKR}}/boss/1" class="btn btn-success btn-sm">{{$result->SKR}}</a></h4>
					</td>
					<td><h6>{{ substr($result->YSDWMC, 9) }}</h6></td>
					<td><h5>{{div($result->JE)}}</h5></td>
					<td @click=hidden({{ $result->id }}) class="btn btn-primary btn-sm"><h6>{{ substr($result->ZFFSMC, 0,3) }}</h6></td>	
					<td >
						<a href="/project/tozfl/{{ filterVillage($result->ZY) }}"
							class="{{ filterVillage($result->ZY)?'btn btn-success btn-sm':'' }}">{{ filterVillage($result->ZY) }}</a></td>
					<td>
							<received :zfpz = {{ $result->id }} 
									  :is_received = {{ $result->received }} ></received>
					</td>
				</tr>	
			@endforeach
		</tbody>
		<tr class='bg-primary'>
			<th><h6>id</h6></th>
			<th><h6>支出ID</h6></th>
			<th><h6>ZBID</h6></th>
			<th><h6>日期</h6></th>
			<th><h6>摘要</h6></th>
			<th><h6>收款人</h6></th>
			<th><h6>预算单位</h6></th>
			<th><h6>{{($results->sum('JE'))/10000}}</h6></th>
			<th><h6>支出类型</h6></th>
			<th><h6>项目村</h6></th>
			<th><h6>received</h6></th>
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