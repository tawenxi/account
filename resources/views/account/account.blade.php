@extends('layouts.default')
@section('content')
<h1>{{ \App\Model\Account::where('account_number', $account_number)->value('account_name') }}
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
				<th>日期</th>
				<th>凭证号</th>
				<th>摘要</th>
				<th>借</th>
				<th>贷</th>
				<th>科目</th>
				<th>余额</th>
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
						<td>{{$result['jie']}}</td>
						<td>{{$result['dai']}}</td>
						<td >{{ $result['kmdm'] }}</td>
						<td >{{ $result['yue'] }}</td>

					</tr>	
				@endforeach
			</tbody>
				<tr class="table-hover">
					<th>ID</th>
				    <th>日期</th>
				    <th>凭证号</th>
				    <th>摘要</th>
				    <th>借</th>
				    <th>贷</th>
				    <th>科目</th>
				    <th>余额</th>
				    </tr>
		</table>
		<hr>
	</div>
</article>
@stop