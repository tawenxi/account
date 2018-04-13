@extends('layouts.default')
@section('content')
<h1>左安镇指标支出所有明细表({{ $results->count().'条' }})</h1>
@include('shared.errors')

<article>
	
	<h2>
	<table class="table table-bordered table-striped table-hover table-condensed table-dark table-sm">
		<caption><center>{{ date("Y-m-d H:i:s") }}</center></caption>

		<thead>
			<tr class='bg-primary'>
				<th>日期</th>
				<th>收入科目</th>				
				<th>金额</th>
				<th>收入</th>
				<th>支出</th>
				<th>金额</th>
				<th>支出科目</th>
			</tr>
		</thead>
		<tbody class='table-hover'>
				@foreach ($results as $result)
			<tr>
				<td>
					{{ $result->QS_RQ }}
				</td>
				<td class="small">
					{{$result->zb->account?
						$result->zb->account->name:
						''}} 
				</td>
				<td>
					{{$result->zb->JE}}
				</td>
				<td class="small">
					{{$result->zb->ZY}}
				</td>
				<td class="small">
					{{$result->ZY}}
				</td>
				<td>
					{{$result->JE}}
				</td>
				
				<td class="small">
					{{$result->account?
						$result->account->name:
						''}} 
				</td>
			</tr>	
			@endforeach
		</tbody>
			<tr class='bg-primary'>
				<th>日期</th>
				<th>收入科目</th>				
				<th></th>
				<th>收入</th>
				<th>支出</th>
				<th>{{($results->sum('JE'))/10000}}</th>
				<th>支出科目</th>
			</tr>
	</table>
			<hr>
	</h2>
</article>
@stop