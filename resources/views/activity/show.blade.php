@extends('layouts.default')
@section('title', '显示历史操作记录')

@section('content')
	

<div class="container">
	<ul class="list-group">
		@include('activity/list')
	</ul>
</div>
@stop
