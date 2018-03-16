
@extends('layouts.default')
@section('content')
<h1>左安镇指标支出所有明细表({{ $results->count().'条' }})</h1>
@if ($results->where('deleted',1)->count())
	<div class="alert alert-danger text-center">
		已被删除({{ $results->where('deleted',1)->count().'条' }})
	</div>
@endif

@if ($results->where('received',0)->count())
	<div class="alert alert-info text-center">
		未收到({{ $results->where('received',0)->count().'条' }})
	</div>
@endif

@if ($results->where('fail',1)->count())
	<div class="alert alert-info text-center">
		支付失败({{ $results->where('fail',1)->count().'条' }})
	</div>
@endif

@include('shared.errors')

<article>
	<?php $i=0 ?>
	
	@if (session('ND') == config('app.MYND'))
		@while ($i++<\Carbon\carbon::now()->month)
			<a href="?search=QS_RQ:{{ session('ND').(($i<9)?('0'.$i):$i )}}"  class="btn btn-success">{{ $i }}</a>
	    @endwhile
	@else
		@while ($i++<12)
		<a href="?search=QS_RQ:{{ session('ND').(($i<9)?('0'.$i):$i )}}"  class="btn btn-success">{{ $i }}</a>
	    @endwhile
	@endif
		
	
	

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
				<th>制单日期</th>
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
					<td class="small">
						<a href="/showzbdetail/{{ $result->ZBID }}" title="{{$result->zb?$result->zb->ZY:'' }}" >{{$result->zb->ZY}}</a> 
					</td>

					<td class="alert-danger">
						{{ $result->PDRQ }}
					</td>
					<td class="alert-success">
						{{$result->QS_RQ}} 
					</td>
					<td>
						<a href="/point/{{$result->id}}" title={{ $result->beizhu }}>
							@if ($result->beizhu)
								<button type="submit" class="btn btn-primary btn-sm">备注</button>
							@endif
							{{$result->ZY}} 
						</a>
					</td>
					<td >
						<a href="{{$result->SKR}}/boss">
							<h4>{{$result->SKR}}</h4>
						</a>
						
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
					{{-- @receive --}}
						<td>
							<received :zfpz = {{ $result->id }} 
									  :is_received = {{ $result->received }} ></received>
							@if ($result->deleted)	
									<button type="submit" class="btn-sm btn-danger btn">已删除</button>
							@endif
							@if ($result->fail)	
									<button type="submit" class="btn-sm btn-danger btn">支付失败</button>
							@endif
						</td>
					{{-- @endreceive --}}

				</tr>	
			@endforeach
		</tbody>
		<tr class='success'>
			<th>id</th>
			<th>支出ID</th>
			<th>ZBID</th>
			<th>制单日期</th>
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