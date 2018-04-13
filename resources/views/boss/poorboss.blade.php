@extends('layouts.default')
@section('content')
<h1>扶贫者({{ $bosses->count() }})</h1>
@include('shared.errors')

<article>
	
	<div class='h4 row'>
		<table class="table table-bordered table-striped table-hover table-condensed table-sm table-dark">
			<caption>
				<center>{{ date("Y-m-d H:i:s") }}</center>
			</caption>

			<thead>
				<tr class='bg-danger'>
				 	
					<th>老板</th>
					<th>支付数量</th>
					<th>总金额</th>
					<th>账号</th>
					<th>开户行</th>
					<th>编辑</th>
				</tr>

				<tr class='warning'>
				 	
					<th>老板</th>
					<th>({{ $bosses->sum(function($item){
						return $item->count();
					}) }})</th>
					<th>({{ $bosses->sum(function($item){
						return $item->sum('JE');
					}) }})</th>
					<th>账号</th>
					<th>开户行</th>
					<th>编辑</th>
					
				</tr>
			</thead>
			<tbody class='table-hover'>
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
					<th>老板</th>
					<th>{{ $bosses->sum(function($item){
						return $item->count();
					}) }}</th>
					<th>总金额</th>
					<th>账号</th>
					<th>开户行</th>
					<th>编辑</th>
				</tr>
		</table>
		<hr>	
	</div>
</article>
@stop