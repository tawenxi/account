@extends('layouts.default')
@section('content')
<h1>{{ $key_word }}
	<br>
	({{ $results->count() }}条数据)</h1>
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
				<th>期间</th>
				<th>凭证号</th>
				<th>摘要</th>
				<th>借贷</th>
				<th>金额</th>
				<th>科目代码</th>
				<th>科目名称</th>
				</tr>
			</thead>
			<tbody class='table-hover'>
				@foreach ($results as $result)
					<tr>
						<td>{{ $loop->index+1 }}</td>
						<td>
							{{$result['kjqj']}}
						</td>
						<td><h6>{{$result['pzh']}}</h6></td>
						<td><h5>{{$result['zy']}}</h5></td>
						<td>{{$result['jdbz']}}</td>
						<td>{{$result['je']}}</td>
						<td ><a href="es?q=*{{ $result['kmdm'] }}">{{ $result['kmdm'] }}</a></td>
						<td >{{ $result['account_name'] }}</td>

					</tr>	
				@endforeach
			</tbody>
				<tr class="table-hover">
					<th>ID</th>
					<th>期间</th>
					<th>凭证号</th>
					<th>摘要</th>
					<th>借贷</th>
					<th>金额</th>
					<th>科目代码</th>
					<th>科目名称</th>
				    </tr>
		</table>
		<hr>
	</div>
</article>
@stop