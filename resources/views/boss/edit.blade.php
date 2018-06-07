@extends('layouts.default')
@section('title', '更新收款人资料')

@section('content')
<div class="col-md-8 offset-md-2">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h1>更新收款人数据</h1>
    </div>
      <div class="panel-body">

        @include('shared.errors')
        <form method="POST" action="{{ route('boss.update') }}">
            {{ csrf_field() }}

            <input type="hidden" name="id" value="{{ $boss->id }}">
            <div class="form-group">
              <label for="description"><font color="black">描述：</font></label>
              <textarea type="textarea" name="description" class="form-control" rows="20" >{{ $boss->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-block btn-success">更新</button>
        </form>
    </div>
  </div>
</div>
@stop