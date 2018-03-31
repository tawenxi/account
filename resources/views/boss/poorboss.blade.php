@extends('layouts.default')
@section('content')
<h1>扶贫者({{ $bosses->count() }})</h1>
@include('shared.errors')

<article>
	
	<div class='h4 row'>
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

				<tr class='warning'>
				 	
					<th class="col-md-2">老板</th>
					<th class="col-md-2">({{ $bosses->sum(function($item){
						return $item->count();
					}) }})</th>
					<th class="col-md-2">({{ $bosses->sum(function($item){
						return $item->sum('JE');
					}) }})</th>
					<th class="col-md-4">账号</th>
					<th class="col-md-2">开户行</th>
					<th class="col-md-2">编辑</th>
					
				</tr>
			</thead>
			<tbody class='alert-info'>
				@foreach ($bosses as $name=>$boss)
						<td >
							<a href="/{{ $name }}/boss/1" }}>{{ $name }}</a>
						</td>
						<td >{{ $boss->count() }}</td>
						<td >{{ $boss->sum('JE') }}</td>
						<td>{{ $boss->last()->SKZH }}<br>
							@foreach (boss_village($name,1) as $village)
								<a href="project/tozfl/{{ $village }}" class="btn btn-success btn-sm">{{ $village }}</a>
							@endforeach 
						</td>
						<td>{{ $boss->last()->SKRKHYH }}</td>
						<td class='btn btn-link'>

							{!! Form::open(['method' => 'get', 'route' => ['boss.edit',$name], 'class' => 'form-horizontal']) !!}
	          				{!! Form::submit('编辑', ['class' => "btn ".(\App\Model\Boss::whereName($name)->first()->description?'btn-primary':'btn-success')." pull-right"]) !!}
	          
	          				{!! Form::close() !!}
					
						</td>


						
					</tr>	

				@endforeach
			</tbody>
				<tr class='success'>
					<th class="col-md-2">老板</th>
					<th class="col-md-2">{{ $bosses->sum(function($item){
						return $item->count();
					}) }}</th>
					<th class="col-md-2">总金额</th>
					<th class="col-md-4">账号</th>
					<th class="col-md-2">开户行</th>
					<th class="col-md-2">编辑</th>
				</tr>
		</table>
		<hr>	
	</div>
</article>
@stop