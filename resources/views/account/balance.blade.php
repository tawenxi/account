@extends('layouts.default')
@section('content')
<h1>({{ $results->count() }}条数据)</h1>
@include('shared.errors')

<article>
	
	<div class='h4'>
		<table class="table table-bordered table-striped table-hover table-dark table-sm">
			<caption>
				<center>{{ date("Y-m-d H:i:s") }}</center>
			</caption>
			<thead>
				<tr class="table-hover">
				<th>ID</th>
				<th>科目代码</th>
				<th>科目名称</th>
				<th>借贷</th>
				<th>余额</th>
				</tr>
			</thead>
			<tbody class='table-hover'>
				@foreach ($results as $result)
					<tr>
						<td>{{ $loop->index+1 }}</td>
						<td>
							{{$result['kmdm']}}
						</td>
						<td><h6><a href="/es?q=*{{ $result['kmdm'] }}">{{$result['kmmc']}}</a></h6></td>
						<td><h5>{{$result['jdbz']}}</h5></td>
						<td>{{$result['balance']}}</td>
					</tr>	
				@endforeach
			</tbody>
				<tr class="table-hover">
				<th>ID</th>
				<th>科目代码</th>
				<th>科目名称</th>
				<th>借贷</th>
				<th>余额</th>
				    </tr>
		</table>
		<hr>
	</div>
</article>
@stop