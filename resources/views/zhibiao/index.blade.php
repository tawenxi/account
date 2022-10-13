@extends('layouts.default')
@section('content')
<h1>左安镇指标明细表!({{ $results->count().'条' }})</h1>
@include('shared.errors')

<article>
	
	<div class='h4'>
		<table class="table table-dark table-bordered table-striped table-hover table-condensed table-sm">
			<caption>
				<center>{{ date("Y-m-d H:i:s") }}</center>
			</caption>

			<thead>
				<tr class='bg-primary'>
				 	<th><h6>id</h6></th>
					{{-- <th><h6>科目</h6></th> --}}
					<th><h6>追述</h6></th>
					<th><h6>指标ID</h6></th>
					<th><h6>日期</h6></th>
					<th><h6>摘要</h6></th>
					{{-- 	<th><h6>指标来源</h6></th> --}}
					<th><h6>预算项目</h6></th>
					<th><h6>总金额</h6></th>
					<th><h6>可用金额</h6></th>
					@if (strstr(url()->full(),'%3A%E6%89%B6%E8%B4%AB'))
						<th><h6>已分配</h6></th>
					@endif
					
					<th><h6>支出数</h6></th>
					<th><h6>已分配</h6></th>
					<th><h6>构成</h6></th>
					<th><h6>构成</h6></th>
					<th><h6>单位</h6></th>
					<th><h6>文件</h6></th>
					<th><h6>可用性</h6></th>
				</tr>
			</thead>
			<tbody class='table-hover'>
				@foreach ($results as $result)
					<tr class={{ $result->getRowClass() }}>
					   	<td>{{ $loop->index+1 }}</td>
					   	<td>
					   		@if ($result->prezbid)
					   			<a href="/sourcezb/{{ $result->ZBID }}" class="btn btn-primary btn-sm">{{ $result->OriginZbYear }}</a>
					   		@endif
					   	</td>					
						<td class="small">
							
							<a href="/showzbdetail/{{ $result->ZBID }}" class="btn btn-success btn-sm">{{substr($result->ZBID,11)}} 
							</a>
						</td>
						<td><h6>{{$result->LR_RQ}}</h6></td>
						<td class="small text-warning" >
							@if ($result->beizhu)
								<button type="submit" title="{{ $result->beizhu() }}" class="btn btn-primary btn-sm">备注</button>
								<a href="/divider/{{ $result->id }}" title="{{$result->beizhu() }}" >
							@endif
							<a href="/es?q={{ '@'.$result->ZY }}" class="btn  btn-success btn-sm">O</a>
							<span class="sm">{{$result->ZY}}</span>
							@if ($result->beizhu)
								</a>
							@endif

						</td>
						<td>{{substr($result->ZJXZMC,0,3)}}</td>
						<td>{{$result->JE}}</td>
						<td>{{div($result->yeamount)}}</td>
						@if (strstr(url()->full(),'%3A%E6%89%B6%E8%B4%AB'))
							<td> {{ $result->devidedCount() }}
	                       </td>
	                    @endif

						<td >{{ $result->costCount() }}</td>
						<td >{{ $result->devidedCount() }}</td>

                        <td>
                        	@if ($result->shouquan())
                        		<a href="#"  class="btn btn-success btn-sm" title="{{ $result->shouquan() }}">{{ 'o' }}</a>
                        	@endif
                        </td>
                        <td>
                        	@if ($result->zhijie())
                        		<a href="#"  class="btn btn-primary btn-sm" title="{{ $result->zhijie() }}">{{ 'o' }}</a>
                        	@endif
                        </td>
						
						{{-- @if (strstr($result->YSDWMC,'扶贫')) --}}
							<td class="btn btn-block btn-success "><a href="{{ strstr($result->YSDWMC,'扶贫')?"/divider/$result->id":"/divider/$result->id" }}" >
				{{-- 		@else
							<td >
						@endif --}}
						
				{{-- 		@if (strstr($result->YSDWMC,'扶贫')) --}}
						<font class="text-danger">{{ $result->YSDW() }}</font>
							</a>
{{-- 						@else
						{{ substr($result->YSDWMC, 9) }}
						@endif --}}
					</td>
					<td>
						<a href="/file/{{ $result->id }}" 
						   class=" {{ $result->files->count()?'btn  btn-success btn-sm':'btn  btn-danger btn-sm' }} "
						   title='{{ $result->MXZBWH }}' >O</a>
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
				<tr class='bg-primary'>
					<th><h6>id</h6></th>
					<th><h6>追述</h6></th>
					<th><h6>指标ID</h6></th>
					<th><h6>日期</h6></th>
					<th><h6>摘要</h6></th>
					<th><h6>预算项目</h6></th>
					<th><h6>{{round($results->sum(function($item){
						return $item->JE;
					})/10000,2)}}</h6></th>

					<th><h6>{{round(round(($results->sum(function($item){
						return $item->JE;
					}))/10000,2)-round($results->sum(function($item){
						return $item->detail;
					})/10000,2),2)}}</h6></th>
					@if (strstr(url()->full(),'%3A%E6%89%B6%E8%B4%AB'))
						<th><h6>已分配</h6></th>
					@endif
					<th><h6>支出数</h6></th>
					<th><h6>已分配</h6></th>
					<th><h6>构成</h6></th>
					<th><h6>构成</h6></th>
					<th><h6>单位</h6></th>
					<th><h6>文件</h6></th>
					<th><h6>可用性</h6></th>
				</tr>
		</table>
		<hr>	
	</div>
</article>
@stop