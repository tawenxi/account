@extends('layouts.default')
@section('content')
<h1>收款人信息表({{ $bosses->count() }})</h1>
@include('shared.errors')

<article>
	
	<div class='h4'>
		<table class="table table-bordered table-dark table-striped table-hover table-condensed table-sm">
			<caption>
				<center>{{ date("Y-m-d H:i:s") }}</center>
			</caption>

			<thead>
				<tr class='bg-danger'>
					<th >老板</th>
					<th >支付数量</th>
					<th >总金额</th>
					<th >账号</th>
					<th /th>
					<th class="">编辑</th>
				</tr>
			</thead>
			<tbody class='table-hover'>
				@foreach ($bosses as $boss)
				<tr>
						<td >
							<a href="/{{ $boss->name }}/boss">{{ $boss->name }}</a>
						</td>
						<td >{{ $boss->payoutcount }}</td>
						<td >{{ $boss->totalpayout }}</td>

						<td>{{ $boss->bankaccount }}<br>
							@cache($boss->name)
							@foreach (boss_village($boss->name,1) as $village)
								<a href="project/tozfl/{{ $village }}" class="btn btn-success btn-sm">{{ $village }}</a>
							@endforeach 
							@endcache
						</td>

						<td>{{ $boss->bank }}</td>
						<td class='btn btn-link'>

							{!! Form::open(['method' => 'get', 'route' => ['boss.edit',$boss->name], 'class' => 'form-horizontal']) !!}
	          				{!! Form::submit('编辑', ['class' => "btn ".($boss->description?'btn-primary':'btn-success')." pull-right"]) !!}
	          
	          				{!! Form::close() !!}
					
						</td>
					</tr>	
				@endforeach
			</tbody>
				<tr class='bg-danger'>
					<th>老板</th>
					<th>支付数量</th>
					<th>{{ $bosses->sum('totalpayout') }}</th>
					<th>账号</th>
					<th>开户行</th>
					<th>编辑</th>

				</tr>
		</table>
		<hr>	
	</div>
</article>
@stop