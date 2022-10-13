@extends('layouts.default')
@section('content')
@foreach ($dates as $date)
@include('salary.date')
@endforeach

<h1>枚江镇工资分月汇总({{ isset($resv[0]['date'])?(is_numeric($resv[0]['date'])?$resv[0]['date']:"" ):'' }})</h1>
@include('shared.errors')

<article>
	<h2>
	<table class="table table-bordered table-striped table-hover table-condensed table-sm table-dark">
		<caption><center>{{ date("Y-m-d H:i:s") }}</center></caption>
		<thead>
			<tr class='bg-primary'>	
				<th>日期</th>
					@include('salary.table')
</article>

@stop
