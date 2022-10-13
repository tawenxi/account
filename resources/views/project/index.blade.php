@extends('layouts.default')
@section('content')
<h1>左安镇扶贫资金明细表({{ $projects->count() }}条数据)</h1>
@include('shared.errors')

<article>
	
	<div class='h4 row'>
		<table class="table table-bordered table-striped table-hover table-condensed table-sm table-dark">
			<caption>
				<center>{{ date("Y-m-d H:i:s") }}</center>
			</caption>
			<thead>
				<tr class='bg-danger'>
				<th>ID</th>
				<th>村别</th>
				<th>年份</th>
				<th>项目类型</th>
				<th>项目名称</th>
				<th>中标价格</th>
				<th>合同价格</th>
				<th>预算价格</th>
				<th>决算价格</th>

				
				<th>资金来源</th>
				<th>已付资金</th>
				<th>拨付率</th>
				<th>编辑</th>
				<th>删除</th>
				<th>图</th>
				</tr>
			</thead>
			<tbody class='table-hover'>
				@foreach ($projects as $project)
					<tr class='alert-default'>
						<td>{{ $loop->index+1 }}</td>
						<td><h6>{{ $project->village->name }}</h6></td>
						<td>{{$project->year}}</td>
						<td><h6>{{$project->category}}</h6></td>
						<td><h6>{{$project->name}}</h6></td>
						<td>{{$project->bidprice}}</td>

						<td>{{$project->contractprice}}</td>
						<td>{{$project->budget}}</td>
						<td>{{$project->settlementprice}}</td>

						<td>
							<a href="project/{{ $project->id }}/project-income">
								{{$income_save = $project->zbs->sum(function($item){
									return $item->pivot->amount;
								})}}~({{ $project->zbs->count() }})
							</a>
						</td>
						<td>
							<a href="project/{{ $project->id }}/project-payout" >{{$payout_save = $project->zfpzs->sum('JE')}}~
								({{ $project->zfpzs->count() }})
							</a>
						</td>
						<td>{{ $income_save?div($payout_save/$income_save):"错误" }}</td>
						<td class='btn btn-link'>

							{!! Form::open(['method' => 'get', 'route' => ['project.edit',$project->id], 'class' => 'form-horizontal']) !!}
	          				{!! Form::submit('编辑', ['class' => 'btn btn-success pull-left']) !!}
	          
	          				{!! Form::close() !!}
					
						</td>
						<td>
							{!! Form::open(['method' => 'delete', 'route' => ['project.destroy',$project->id], 'class' => 'form-horizontal']) !!}
	          				{!! Form::submit('删除', ['class' => 'btn btn-danger pull-right']) !!}
	          
	          				{!! Form::close() !!}
						</td>
						<td class="">
							<a href="/projects-chart?village={{ $project->village->id }}" >图</a>
						</td>
					</tr>	
				@endforeach
			</tbody>
			
				<tr class='bg-danger'>
				<th>ID</th>
				<th>村别</th>
				<th>年份</th>
				<th>项目类型</th>
				<th>项目名称</th>
				<th>中标价格</th>
				<th>合同价格</th>
				<th>预算价格</th>
				<th>决算价格</th>

				
				<th>资金来源</th>
				<th>已付资金</th>
				<th>拨付率</th>
				<th>编辑</th>
				<th>删除</th>
				<th>图</th>

				</tr>
			
		</table>
		<hr>
	</div>
</article>
@stop