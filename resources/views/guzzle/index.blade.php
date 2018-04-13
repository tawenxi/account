@extends('layouts.default')
@section('content')
<h1>左安镇授权支付指标明细表({{ $guzzledbs->count() }}条数据)</h1>
@include('shared.errors')

<article>
	
	<div class='h4'>
		<table class="table table-bordered table-striped table-hover table-dark table-sm">
			<caption>
				<center>{{ date("Y-m-d H:i:s") }}</center>
			</caption>
			<thead>
				<tr class="table-hover">
				<th scope="col">ID</th>
				<th scope="col">指标ID</th>
				<th scope="col">摘要</th>
				<th scope="col">预算项目</th>
				<th scope="col">总金额</th>
				<th scope="col">可用金额</th>
				<th scope="col">编辑</th>
				</tr>
			</thead>
			<tbody class='table-hover'>
				@foreach ($guzzledbs as $guzzledb)
					<tr class={{ empty($guzzledb->body)?'bg-danger':(
						$guzzledb->useable?'alert-success':'')}}>
						<td>{{ $loop->index+1 }}</td>
						<td>
							<a  class="badge badge-primary" href="{{ $guzzledb->ZBID }}/show">{{$guzzledb->ZBID}}
							</a>
						</td>
						<td>{{$guzzledb->ZY}}</td>
						<td>{{$guzzledb->ZJXZMC}}</td>
						<td>{{$guzzledb->YKJHZB}}</td>
						<td>{{$guzzledb->KYJHJE}}</td>
						<td class='btn btn-link'>

							{!! Form::open(['method' => 'get', 'route' => ['guzzle.edit',$guzzledb->id], 'class' => 'form-horizontal']) !!}
	          				{!! Form::submit('编辑', ['class' => 'btn btn-success pull-right']) !!}
	          
	          				{!! Form::close() !!}
					
						</td>
					</tr>	
				@endforeach
			</tbody>
				<tr class="table-hover">
					<th>ID</th>
					<th>指标ID</th>
					<th>摘要</th>
					<th>预算项目</th>
					<th>{{div(($guzzledbs->sum('YKJHZB'))/10000)}}</th>
					<th>{{div($guzzledbs->sum('KYJHJE')/10000)}}</th>
					<th>编辑</th>
				</tr>
		</table>
		<hr>
	</div>
</article>
@stop