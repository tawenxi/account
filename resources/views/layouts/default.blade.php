<!DOCTYPE html>
<html>
  <head>
    <title>@yield('title', '左安镇财务查询系统')</title>
    <link rel="stylesheet" href={{ asset('css/app.css') }}>
    <link rel="stylesheet" href="/css/libs.css">
    <link href="/css/toastr.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/dropzone.min.css">
{{--     <style>
    tbody {
        display:block;
        max-height:600px;
        overflow:auto;
    }
    thead, tbody tr {
        display:table;
        width:100%;
        table-layout:fixed;
        overflow: scroll;
    }
    tr td {
      word-wrap:break-word;
    }
    </style> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta name="turbolinks-visit-control" content="reload"> --}}

    <script src={{ mix('/js/app.js') }}></script>
    <script src="/js/socket.io.slim.js"></script>
    <script src="/js/toastr.min.js"></script>
  </head>
  <body style="padding-top: 0px;background:url('/image/bg{{ random_int(11, 11) }}.jpg') fixed;">
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
    @yield('content2')
      <script src="/js/libs.js"></script>
      @include('shared._flash')
      @yield('js')
  </body>
</html>