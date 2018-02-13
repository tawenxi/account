@extends('layouts.default')
@section('content')
<h1>BOSS</h1>
@include('shared.errors')

<article>
	
	<row class='h4'>
		<table class="table table-bordered table-striped table-hover table-condensed">
			<caption>
				<center>{{ date("Y-m-d H:i:s") }}</center>
			</caption>

			<thead>
				<tr class='success'>
				 	
					<th class="col-md-6">老板</th>
					<th class="col-md-2">支付数量</th>
					<th class="col-md-4">总金额</th>
				</tr>
			</thead>
			<tbody class='alert-info'>
				@foreach ($bosses as $name=>$boss)
						<td >
							<a href="/{{ $name }}/boss">{{ $name }}</a>
						</td>
						<td >{{ $boss->count() }}</td>
						<td >{{ $boss->sum('JE') }}</td>
					</tr>	
				@endforeach
			</tbody>
				<tr class='success'>
					<th class="col-md-6">老板</th>
					<th class="col-md-2">支付数量</th>
					<th class="col-md-4">总金额</th>
				</tr>
		</table>
		<hr>	
	</row class='h4'>
</article>
@stop