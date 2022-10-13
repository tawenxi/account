@extends('layouts.default')
@section('content')
<h1>左安镇授权支付指标明细表({{ $guzzledbs->count() }}条数据)</h1>
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
				<th>指标ID</th>
				<th>摘要</th>
				<th>预算项目</th>
				<th>总金额</th>
				<th>可用金额</th>
				<th>编辑</th>
				</tr>
			</thead>
			<tbody class='table-hover'>
				@foreach ($guzzledbs as $guzzledb)
					<tr class={{ empty($guzzledb->body)?'bg-danger':(($guzzledb->ZCLXDM!='0202')?'bg-warning':(
						$guzzledb->useable?'alert-success':''))}}>
						<td>{{ $loop->index+1 }}</td>
						<td>
							<a href="/showzbdetail/{{ $guzzledb->ZBID }}" class="btn btn-warning btn-sm">O</a>
							<a  class="badge badge-primary" href="{{ $guzzledb->ZBID }}/show"
								
							>{{substr($guzzledb->ZBID,11)}}
							</a>

							<button type="button" class="btn btn-sm btn-success" @click=doCopy("{{ $guzzledb->ZBID }}")>O</button>
						</td>
						<td><h6>{{$guzzledb->ZY}}</h6></td>
						<td><h5>{{$guzzledb->ZJXZMC}}</h5></td>
						<td>{{$guzzledb->YKJHZB}}</td>
						<td>{{$guzzledb->KYJHJE}}</td>
						<td >
	          				<form action="{{ route('guzzle.edit', $guzzledb->id) }}" method="get">
					        {{ csrf_field() }}
					        <button type="submit" class="btn btn-sm btn-success delete-btn">编辑</button>
					      </form>
						</td>
					</tr>	
				@endforeach
			</tbody>
				<tr class="table-hover">
					<th>ID</th>
					<th>指标ID</th>
					<th>摘要</th>
					<th>预算项目</th>
					<th>{{div(($guzzledbs->sum('YKJHZB'))/10000)}}</th>
					<th>{{div($guzzledbs->sum('KYJHJE')/10000)}}</th>
					<th>编辑</th>
				</tr>
		</table>
		<hr>
	</div>
</article>
@stop