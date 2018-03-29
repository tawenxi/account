@extends('layouts.default')
@section('content')
<h1>收款人信息表({{ $bosses->count() }})</h1>
@include('shared.errors')

<article>
	
	<row class='h4'>
		<table class="table table-bordered table-striped table-hover table-condensed">
			<caption>
				<center>{{ date("Y-m-d H:i:s") }}</center>
			</caption>

			<thead>
				<tr class='success'>
				 	
					<th class="col-md-2">老板</th>
					<th class="col-md-2">支付数量</th>
					<th class="col-md-2">总金额</th>
					<th class="col-md-4">账号</th>
					<th class="col-md-2">开户行</th>
					<th class="col-md-2">编辑</th>
									</tr>
			</thead>
			<tbody class='alert-info'>
				@foreach ($bosses as $boss)
						<td >
							<a href="/{{ $boss->name }}/boss" title={{ boss_village($boss->name) }}>{{ $boss->name }}</a>
						</td>
						<td >{{ $boss->payoutcount }}</td>
						<td >{{ $boss->totalpayout }}</td>
						<td>{{ $boss->bankaccount }}</td>
						<td>{{ $boss->bank }}</td>
						<td class='btn btn-link'>

							{!! Form::open(['method' => 'get', 'route' => ['boss.edit',$boss->name], 'class' => 'form-horizontal']) !!}
	          				{!! Form::submit('编辑', ['class' => "btn ".($boss->description?'btn-primary':'btn-success')." pull-right"]) !!}
	          
	          				{!! Form::close() !!}
					
						</td>
					</tr>	
				@endforeach
			</tbody>
				<tr class='success'>
					<th class="col-md-2">老板</th>
					<th class="col-md-2">支付数量</th>
					<th class="col-md-2">{{ $bosses->sum('totalpayout') }}</th>
					<th class="col-md-4">账号</th>
					<th class="col-md-2">开户行</th>
					<th class="col-md-2">编辑</th>

				</tr>
		</table>
		<hr>	
	</row class='h4'>
</article>
@stop