@inject('request',"Illuminate\Http\Request")
<header class="navbar navbar-fixed-top navbar-inverse">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <div class="container">
    <div class="col-md-offset-0 col-md-12">
     @if (\Auth::check())
      {{-- <a href="{{ (\Auth::user()->id==39)?'/preview':'/geren'}}" id="logo"> --}}
      <a href="{{ (\Auth::user()->id==39 OR \Auth::user()->id==36)?'/session':'/geren'}}" 
         id="logo"
        data-turbolinks="false">
      {{ session('ND') }}</a>
      @else
      <a href="" id="logo">左安镇工资查询系统</a>
      @endif
      @auth
     <nav class="navbar navbar-expand-lg navbar-dark  pull-right">
        <div class="collapse navbar-collapse" id="navbarsExample07">
          <ul class="navbar-nav mr-auto ">
        <li class="nav-item active"><a class="nav-link" href="{{ url()->full().(stristr(Request::getRequestUri(), '?')?'&':'?').'export=1' }}">导出excel</a></li>
               {{--     @can('showAllSalary')      --}}

            <li  class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle"  id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 收款人 <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">      
                  <li><a class="dropdown-item"  href="/company">公司收款人</a></li>
                  <li><a class="dropdown-item"  href="/personalboss">个人收款人</a></li>
                  <li class="divider"></li> 
                  <li><a class="dropdown-item"  href="/poorboss">扶贫者</a></li>
                  <li class="divider"></li>
                </ul>
              </li>

            <li  class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle"  id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 项目管理 <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">      
                  <li><a class="dropdown-item"  href="/project">所有项目</a></li>
                  <li><a class="dropdown-item"  href="/village">平困村</a></li>
                  <li class="divider"></li>
                  <li><a class="dropdown-item"  href="/zhibiao?search=YSDWMC:扶贫">[扶贫指标]</a></li>
                  <li><a class="dropdown-item"  href="/zbdetail?search=YSDWMC:扶贫">[扶贫支付令]</a></li>
                  <li><a class="dropdown-item"  href="/project/create">新建项目</a></li>


                </ul>
              </li>
             <li><a class="nav-link" href="/searchacc">查询</a></li> 
             

             <li  class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle"  id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 监控台 <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">      
                  <li><a class="dropdown-item"  href="/redis">实时监控</a></li>
                  <li><a class="dropdown-item"  href="/rediscache">缓存监控</a></li>
                  <li class="divider"></li>
                  <li><a class="dropdown-item"  href="/dpt">平台更新</a></li>  
                </ul>
              </li>

              <li  class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle"  id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 大平台 <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">      
                  
                  <li><a class="dropdown-item"  href="/hyy?search=KYJHJE:0">授权指标</a></li>
                  <li><a class="dropdown-item"  href="/zhijie?search=KYJHJE:0">直接指标</a></li>

                  <li><a class="dropdown-item"  href="/dpt">平台更新</a></li>   
                  <li><a class="dropdown-item"  href="/payout">授权登记</a></li>
                    <li class="divider"></li>
                </ul>
              </li>
                {{--    @endcan --}}
                {{--  @can('showAllSalary')   --}}   
              <li  class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle"  id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 指标查询<b class="caret"></b>
                </a>
                <ul class="dropdown-menu">      
                <li><a class="dropdown-item"  href="/inco">收支对照</a></li>
                <li><a class="dropdown-item"  href="/zhibiao/?search=yeamount:1&orderBy=LR_RQ">[收入]</a></li>
                <li><a class="dropdown-item"  href="/zhibiao/?search=yeamount:1;KYX:1&orderBy=LR_RQ&searchJoin=and">[可用收入]</a></li>
                <li><a class="dropdown-item"  href="/zhibiao/?search=yeamount:1;KYX:0&orderBy=LR_RQ&searchJoin=and">[不可用收入]</a></li>
                <li><a class="dropdown-item"  href="{{ session('ND')==2018?'/zbdetail':'/zbdetail?search=YSDWMC:扶贫' }}">[支出]</a></li>
                <li><a class="dropdown-item"  href="/checkout">[检核]</a></li>
                <li><a class="dropdown-item"  href="/shenqing">申请单</a></li>
                <li><a class="dropdown-item"  href="/incomes">收入</a></li> 
                <li><a class="dropdown-item"  href="/costs">支出</a></li>
                <li><a class="dropdown-item"  href="/income/create">新建收入</a></li> 
                    <li class="divider"></li>
                <li><a class="dropdown-item"  href="{{ strstr(url()->full(),'ZFFSMC')?(strstr(url()->full(),'%E7%9B%B4%E6%8E%A5')?str_replace('%E7%9B%B4%E6%8E%A5','%E6%8E%88%E6%9D%83',url()->full()):url()->full()):url()->full().';ZFFSMC:授权&searchJoin=and' }}">授权</a></li> 
                <li><a class="dropdown-item"  href="{{ strstr(url()->full(),'ZFFSMC')?(strstr(url()->full(),'%E6%8E%88%E6%9D%83')?str_replace('%E6%8E%88%E6%9D%83','%E7%9B%B4%E6%8E%A5',url()->full()):url()->full()):url()->full().';ZFFSMC:直接&searchJoin=and' }}">直接</a></li> 


                    <li class="divider"></li>
                    <li><a class="dropdown-item"  href="/zbdetail?search=received:0">缺失账单</a></li> 
                    <li><a class="dropdown-item"  href="/zbdetail?search=qs:0&searchFields=qs:=">尚未生效</a></li>
                    <li class="divider"></li>
                    <li><a class="dropdown-item"  href="/zbdetail?search=deleted:1">[系统已删除]</a></li>
                    <li><a class="dropdown-item"  href="/zbdetail?search=fail:1">[账号错误]</a></li>
                    <li class="divider"></li>
                    <li><a class="dropdown-item"  href="/boss">Boss</a></li> 



                </ul>

              </li>
               {{--  @endcan --}}
               {{-- @can('showAllSalary')      --}}
              <li  class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle"  id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 知乎 <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">      
                <li><a class="dropdown-item"  href="/zhibiaos">[收入]</a></li>
                <li><a class="dropdown-item"  href="/zbdetails">[支出]</a></li>
                </ul>
              </li>    
                  {{--       @endcan --}}
                  {{--      @can('showAllSalary') --}}
              <li  class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle"  id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 工资 <b class="caret"></b>
                </a>  
                <ul class="dropdown-menu">      
                    <li><a class="dropdown-item"  href="">月工资表</a></li>
                    <li><a class="dropdown-item"  href="/bumen">月部门</a></li>
                    <li><a class="dropdown-item"  href="/byear/2018/">分部汇总</a></li>
                    <li><a class="dropdown-item"  href="/myear/2018/">分月汇总</a></li>
                    <li><a class="dropdown-item"  href="/geren">个人</a></li>
                    <li><a class="dropdown-item"  href="/phb">封神榜</a></li>     
                    <li class="divider"></li>
                </ul>
              </li>

               {{--        @endcan    --}} 
            <li  class="nav-item dropdown">
              <a href="#" class="nav-link dropdown-toggle"  id="dropdown07" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ \Auth::check()?Auth::user()->name:"" }} <b class="caret"></b>
              </a>
               @if (\Auth::check())
              <ul class="dropdown-menu">  
                <li><a class="dropdown-item"  href="{{ route('edit') }}">修改密码</a></li>
                <li class="divider"></li>
                <li>
                  <a id="logout" href="#">
                    <form action="{{ route('logout') }}" method="POST">
                      {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                      <button class="btn btn-block btn-danger" type="submit" name="button">退出</button>
                    </form>
                  </a>
                </li>
      
              </ul>
              @endif
            </li>    
        </ul>
        </div>
      </nav>
      @endauth
    </div>
  </div>
</header>





