<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title', '左安镇财务查询系统')</title>
    <link rel="stylesheet" href={{ asset('css/app.css') }}>
    <link rel="stylesheet" href="/css/libs.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body >
@if (!\Auth::check())
  @include('layouts._header')
@endif
@can('export')
    @include('layouts._header')
@endcan
    <div class="container" id="app">
      <div class="col-md-offset-0 col-md-12">
      <br><br>
        @include('shared.messages')
        @include('shared.errors')
        @yield('content')
@can('export')
        @include('layouts._footer')
@endcan
@if (!\Auth::check())
  @include('layouts._footer')
@endif
      </div>
    </div>
      
      <script src={{ mix('/js/app.js') }}></script>
      <script src="/js/libs.js"></script>
      @include('shared._flash')
      @yield('js')
  </body>
</html>