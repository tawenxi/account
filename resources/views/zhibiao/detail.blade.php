@extends('layouts.default')
@section('content')
<h1>左安镇指标支出所有明细表({{ $results->count().'条' }})</h1>
@if ($results->where('deleted',1)->count())
	<div class="alert alert-danger text-center">
		已被删除({{ $results->where('deleted',1)->count().'条' }})
	</div>
@endif

@if ($results->where('received',0)->count())
	<div class="alert alert-success text-center">
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
		
	
	<hr>

	<div  class='h4 row'>
	<table class="table table-dark table-bordered table-striped table-condensed table-sm table-hover">
		<caption>
			<center>{{ date("Y-m-d H:i:s") }}</center>
		</caption>

		<thead>
			<tr class='bg-primary  '>
				<th><h6>id</h6></th>
				<th><h6>支出ID</h6></th>
				<th><h6>ZBID</h6></th>
				<th><h6>制单日期</h6></th>
				<th><h6>日期</h6></th>
				<th><h6>摘要</h6></th>
				<th><h6>收款人</h6></th>
				<th><h6>预算单位</h6></th>
				<th><h6>总金额</h6></th>
				<th><h6>支出类型</h6></th>
				<th><h6>Received</h6></th>
			</tr>
		</thead>
		<tbody class='table-hover'>
			@foreach ($results as $result)
				<tr v-show="test({{ $result->id }})" class={{ isset($result->project)?'bg-warning':""}}>
			 		<td>
			 			{{ $loop->index+1 }}
			 		</td>
					<td class="small">
						
							@if (!is_null($result->account))
								<a href="{{ route('zbdetail.edit',['id'=>$result->id]) }}">
									<h6>{{$result->account->name}} </h6>
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
						<a href="/showzbdetail/{{ str_replace('.', '-', $result->ZBID) }}" >
							<h6>{{$result->zb->ZY}}</h6>
						</a> 
					</td>

					<td class="alert-danger">
						{{ $result->PDRQ }}
					</td>
					<td class="alert-success">
						{{$result->QS_RQ}} 
					</td>
					<td >
						<a href="/point/{{$result->id}}" title={{ $result->beizhu }}>
							@if ($result->beizhu)
								<button type="submit" class="btn btn-primary btn-sm">备注</button>
							@endif
							<h6>{{$result->ZY}}</h6>
						</a>
					</td>
					<td >
						<a href="/{{$result->SKR}}/boss">
							<h6>{{$result->SKR}}</h6>
						</a>
						
					</td>
					<td>
						<h6>{{ substr($result->YSDWMC, 9) }}</h6>
					</td>
					<td>
						{{div($result->JE)}}
					</td>
					<td @click=hidden({{ $result->id }}) class="btn btn-primary">
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
		<tr class='bg-primary'>
			<th><h6>id</h6></th>
			<th><h6>支出ID</h6></th>
			<th><h6>ZBID</h6></th>
			<th><h6>制单日期</h6></th>
			<th><h6>日期</h6></th>
			<th><h6>摘要</h6></th>
			<th><h6>收款人</h6></th>
			<th><h6>预算单位</h6></th>
			<th><h6>{{($results->sum('JE'))/10000}}</h6></th>
			<th><h6>支出类型</h6></th>
			<th><h6>received</h6></th>
		</tr>
		
		{{-- {{ $results->appends(['sort' => 'votes'])->links() }} --}}
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