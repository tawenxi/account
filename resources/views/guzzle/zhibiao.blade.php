@inject('account', 'App\Services\Account')
@extends('layouts.default')
@section('content')

<br><br><br>
<h1>枚江镇指标明细表({{ $results->count().'条' }})</h1>
@include('shared.errors')

<article>
	
	<h2>
	<form action="/storeaccount_for_zb" method="post">
	{!! csrf_field() !!}
	<table class="table table-bordered table-striped table-hover table-condensed table-sm table-dark">
		<caption><center>{{ date("Y-m-d H:i:s") }}</center></caption>

		<thead>
			<tr class='bg-primary'>
				<th>指标ID</th>
				<th>日期</th>
				<th>摘要</th>
				<th>科目</th>
				<th>总金额</th>
				<th>可用金额</th>
				<th>支出数</th>
				<th>单位</th>
			</tr>
		</thead>
		<tbody class='table-hover'>
				@foreach ($results as $result)
				
			<tr class={{ abs($result->JE-$result->zfpzs->sum('JE'))<1?'alert-danger':""}}>
				<td>
				
					<a href="showzbdetail/{{ $result->ZBID }}">{{$result->ZBID}} 

					</a>
				
				</td>
					<td>
				
					{{$result->LR_RQ}}
				
				</td>
				<td>
				
					{{$result->ZY}}
				
				</td>

				<td>

					{{$result->account?
						$result->account->account_name:''}} 
				
				</td>
				<td>
				
					{{$result->JE}}
				
				</td>
				
				<td>
				
					{{round($result->JE-$result->zfpzs->sum('JE'),2)}}
				
				</td>
				<td >
				
			
				{{ $result->zfpzs->count() }}
				</td>
					<td >
				
			
				{{ $result->YSDWMC }}
				</td>
			</tr>	

			<tr>
				<td colspan="8" class="bg-danger">
				
              			 <Makeaccount :account={{ $account->getAccount() }}
                                  :zfpz={{ $result->id }}  
                         ></Makeaccount>
					
			</td></tr>

			@endforeach
		</tbody>
					<tr class='bg-primary'>
				<th>指标ID</th>
				<th>日期</th>
				<th>摘要</th>
	{{-- 			<th>指标来源</th> --}}
				<th>预算项目</th>
				<th>{{($results->sum('JE'))/10000}}</th>
				<th>{{($results->sum('JE'))/10000-$results->sum('detail')/10000}}</th>
				<th>支出数</th>
				<th>单位</th>
			</tr>
	</table>
	<button type="submit" class="btn btn-default btn-block">设置科目</button>	
</form>


	
	</h2>
</article>

@stop