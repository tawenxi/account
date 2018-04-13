@extends('layouts.default')
@section('content')

<h1>枚江镇工资个人汇总({{ isset($resv[0]['name'])?$resv[0]['name']:'' }})</h1>

<h3><center><a href="/edit">点我修改密码</a>
</center></h3>
@include('shared.errors')

<article>
	
	<h2>
	<table class="table table-bordered table-striped table-hover table-condensed table-sm table-dark">
		<caption>
			<center>
				{{ date("Y-m-d H:i:s") }}
			</center>
		</caption>

		<thead>
			<tr class='bg-primary'>
				<th>日期</th>
				@include('salary.table')
</article>

@stop
