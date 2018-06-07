@extends('layouts.default')
@section('content')
<h1>左安镇指标支出所有明细表({{ $results->count().'条' }})</h1>
@if (strstr(url()->full(),'sourcezb') AND $results->first())
<h1>原始指标总额({{ findOriginZb($results->first()->zb->ZBID)->JE.'元' }})</h1>
<h1>原始指标ID({{ findOriginZb($results->first()->zb->ZBID)->ZBID }})</h1>
@endif
@if ($count1 = $results->filter(function($item){
	return $item->deleted == 1;
})->count())
	<div class="alert alert-danger text-center">
		已被删除({{ $count1.'条' }})
	</div>
@endif

@if ($count2 = $results->filter(function($item){
	return $item->received == 0;
})->count())
	<div class="alert alert-success text-center">
		未收到({{ $count2.'条' }})
	</div>
@endif

@if ($count3 = $results->filter(function($item){
	return $item->fail == 1;
})->count())
	<div class="alert alert-info text-center">
		支付失败({{ $count3.'条' }})
	</div>
@endif

@include('shared.errors')

<article>
	<?php $i=0 ?>
	
	@if (session('ND') == config('app.MYND'))
		@while ($i++<\Carbon\carbon::now()->month)
			<a href="/zbdetail?search=QS_RQ:{{ session('ND').(($i<10)?('0'.$i):$i )}}"  class="btn btn-success">{{ $i }}</a>
	    @endwhile
	@else
		@while ($i++<12)
		<a href="/zbdetail?search=QS_RQ:{{ session('ND').(($i<10)?('0'.$i):$i )}}"  class="btn btn-success">{{ $i }}</a>
	    @endwhile
	@endif
		
	
	<hr>

	<div  class='h4 row'>
	<table class="table table-dark table-bordered table-striped table-condensed table-sm table-hover "  >
		<caption>
			<center>{{ date("Y-m-d H:i:s") }}</center>
		</caption>

		<thead>
			<tr class='bg-primary  '>
				<th><h6>id</h6></th>
				<th><h6>科目</h6></th>
				<th><h6>ZBID</h6></th>
				<th><h6>制单日期</h6></th>
				<th><h6>日期</h6></th>
				<th><h6>摘要</h6></th>
				<th><h6>收款人</h6></th>
				<th><h6>预算单位</h6></th><th><h6>相关村</h6></th>
				<th><h6>总金额</h6></th>
				<th><h6>支出类型</h6></th>
				<th><h6>Received</h6></th>
			</tr>
		</thead>
		<tbody class='table-hover'>
			@foreach ($results as $result)
				<tr v-show="isHiddenMe({{ $result->id }})" class={{ isset($result->project)?'bg-warning':""}}>
			 		<td v-bind:class="{'btn btn-danger': isColorMe({{ $result->id }})}" 
			 			@click=colored({{ $result->id }})>
			 			<h6>{{ $loop->index+1 }} </h6>
			 		</td>
					<td class="small">
						
							@if (!is_null($result->account))
								<a href="{{ route('zbdetail.edit',['id'=>$result->id]) }}" title="{{ $result->account->name }}">
									{{-- <h6>{{$result->account->name}} </h6> --}}
									<h6> {{ $result->accountname() }} </h6>
								</a>
							@else
								<form 	 method="GET"
										 action="{{ route('zbdetail.edit',['id'=>$result->id]) }}" 
										 enctype="multipart/form-data">
									<button type="submit" class="btn btn-success center-block">编辑</button>
								</form>
								
							@endif
						
					</td>
					<td class="small " style="word-break:break-all; word-wrap:break-all;">
						@if ($result->zb->prezbid)
					   			<a href="/sourcezb/{{ $result->zb->ZBID }}" class="btn btn-primary btn-sm">{{ $result->zb->OriginZbYear }}</a>
					   	@endif
						<a href="/showzbdetail/{{ $result->zbid() }}" >
							<span class="small">{{$result->zb->ZY}}</span>
						</a> 
					</td>

					<td >
						<h6 class="btn btn-primary btn-sm" >{{ substr($result->PDRQ, 3) }}</h6>
					</td>
					<td  >
						<h6 class="{{ $result->getclass() }}">
							{{ $result->status }} </h6>

						
					</td>
					<td >
						<a href="/point/{{$result->id}}" title={{ $result->beizhu }}>
							@if ($result->beizhu)
								<button type="submit" class="btn btn-primary btn-sm">备注</button>
							@endif
							<h6 style="word-break:break-all; word-wrap:break-all;">{{$result->ZY}}</h6>
						</a>
					</td>
					<td >
						<a href="/{{$result->SKR}}/boss">
							<h6 class="{{ $result->getCaizhengClass() }}">{{$result->SKR}}</h6>
						</a>
						
					</td>
					<td>
						<h6 class="btn btn-primary btn-sm">{{ $result->YSDW() }}</h6>
					</td>
					<td>
						<h6><a class="{{ $result->villageClass() }}" href={{ $result->villageLink() }}>{{ $result->village }}</a></h6>
					</td>
					<td>
						@if ($result->SH_RQ AND !$result->QS_RQ)
							<span style="color: green">{{ $result->amount() }}</span>

						@else
							{{ $result->amount() }}
						@endif
						
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
			<th><h6>科目</h6></th>
			<th><h6>ZBID</h6></th>
			<th><h6>制单日期</h6></th>
			<th><h6>日期</h6></th>
			<th><h6>摘要</h6></th>
			<th><h6>收款人</h6></th>
			<th><h6>预算单位</h6></th><th><h6>相关村</h6></th>
			<th><h6>{{($results->sum(function($val){
				return $val->JE;
			}))/10000}}</h6></th>
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