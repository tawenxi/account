@extends('layouts.default')
@section('content')
<h1>左安镇扶贫资金明细表({{ $projects->count() }}条数据)</h1>
@include('shared.errors')

<article>
	
	<row class='h4'>
		<table class="table table-bordered table-striped table-hover table-condensed">
			<caption>
				<center>{{ date("Y-m-d H:i:s") }}</center>
			</caption>
			<thead>
				<tr class='success'>
				<th>ID</th>
				<th>村别</th>
				<th>年份</th>
				<th>项目类型</th>
				<th>项目名称</th>
				
				<th>资金来源</th>
				<th>已付资金</th>
				<th>拨付率</th>
				<th>编辑</th>
				</tr>
			</thead>
			<tbody class='alert-info'>
				@foreach ($projects as $project)
					<tr class='alert-default'}}>
						<td>{{ $loop->index+1 }}</td>
						<td>{{ $project->village->name }}</td>
						<td>{{$project->year}}</td>
						<td>{{$project->category}}</td>
						<td>{{$project->name}}</td>
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
	          				{!! Form::submit('编辑', ['class' => 'btn btn-success pull-right']) !!}
	          
	          				{!! Form::close() !!}
					
						</td>
					</tr>	
				@endforeach
			</tbody>
			
				<tr class='success'>
				<th>ID</th>
				<th>村别</th>
				<th>年份</th>
				<th>项目类型</th>
				<th>项目名称</th>
				
				<th>资金来源</th>
				<th>已付资金</th>
				<th>拨付率</th>
				<th>编辑</th>
				</tr>
			
		</table>
		<hr>
	</row>
</article>
@stop