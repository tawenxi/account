@inject('request',"Illuminate\Http\Request")
<header class="navbar navbar-fixed-top navbar-inverse">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <div class="container">
    <div class="col-md-offset-0 col-md-12">
     @if (\Auth::check())
      {{-- <a href="{{ (\Auth::user()->id==39)?'/preview':'/geren'}}" id="logo"> --}}
      <a href="{{ (\Auth::user()->id==39 OR \Auth::user()->id==36)?'/session':'/geren'}}" id="logo">
      {{ session('ND') }}</a>
      @else
      <a href="" id="logo">左安镇工资查询系统</a>
      @endif
      @auth
      <nav>
        <ul class="nav navbar-nav navbar-right">
        <li><a href="{{ url()->full().(stristr(Request::getRequestUri(), '?')?'&':'?').'export=1' }}">导出excel</a></li>
               {{--     @can('showAllSalary')      --}}
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                 项目管理 <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">      
                  <li><a href="/project">所有项目</a></li>
                  <li><a href="/village">平困村</a></li>
                  <li class="divider"></li>
                  <li><a href="/zhibiao?search=YSDWMC:扶贫">[扶贫指标]</a></li>
                  <li><a href="/zbdetail?search=YSDWMC:扶贫">[扶贫支付令]</a></li>
                  <li><a href="/project/create">新建项目</a></li>


                </ul>
              </li>
             <li><a href="/searchacc">查询</a></li> 
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                 大平台 <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">      
                  <li><a href="/payout">授权登记</a></li>
                  <li><a href="/hyy?search=KYJHJE:0">外网查询</a></li>
                  <li><a href="/dpt">平台更新</a></li>   
                    <li class="divider"></li>
                </ul>
              </li>
                {{--    @endcan --}}
                {{--  @can('showAllSalary')   --}}   
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                 指标查询<b class="caret"></b>
                </a>
                <ul class="dropdown-menu">      
                <li><a href="/inco">收支对照</a></li>
                <li><a href="/zhibiao/?search=yeamount:1&orderBy=LR_RQ">[收入]</a></li>
                <li><a href="/zhibiao/?search=yeamount:1;KYX:1&orderBy=LR_RQ&searchJoin=and">[可用收入]</a></li>
                <li><a href="/zhibiao/?search=yeamount:1;KYX:0&orderBy=LR_RQ&searchJoin=and">[不可用收入]</a></li>
                <li><a href="{{ session('ND')==2018?'/zbdetail':'/zbdetail?search=YSDWMC:扶贫' }}">[支出]</a></li>
                <li><a href="/checkout">[检核]</a></li>
                <li><a href="/shenqing">申请单</a></li>
                <li><a href="/incomes">收入</a></li> 
                <li><a href="/costs">支出</a></li>
                <li><a href="/income/create">新建收入</a></li> 
                    <li class="divider"></li>
                <li><a href="{{ strstr(url()->full(),'ZFFSMC')?(strstr(url()->full(),'%E7%9B%B4%E6%8E%A5')?str_replace('%E7%9B%B4%E6%8E%A5','%E6%8E%88%E6%9D%83',url()->full()):url()->full()):url()->full().';ZFFSMC:授权&searchJoin=and' }}">授权</a></li> 
                <li><a href="{{ strstr(url()->full(),'ZFFSMC')?(strstr(url()->full(),'%E6%8E%88%E6%9D%83')?str_replace('%E6%8E%88%E6%9D%83','%E7%9B%B4%E6%8E%A5',url()->full()):url()->full()):url()->full().';ZFFSMC:直接&searchJoin=and' }}">直接</a></li> 


                    <li class="divider"></li>
                    <li><a href="/zbdetail?search=received:0">缺失账单</a></li> 
                    <li><a href="/zbdetail?search=qs:0&searchFields=qs:=">尚未生效</a></li>
                    <li class="divider"></li>
                    <li><a href="/zbdetail?search=deleted:1">[系统已删除]</a></li>
                    <li><a href="/zbdetail?search=fail:1">[账号错误]</a></li>
                    <li class="divider"></li>
                    <li><a href="/boss">Boss</a></li> 



                </ul>

              </li>
               {{--  @endcan --}}
               {{-- @can('showAllSalary')      --}}
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                 知乎 <b class="caret"></b>
                </a>
                <ul class="dropdown-menu">      
                <li><a href="/zhibiaos">[收入]</a></li>
                <li><a href="/zbdetails">[支出]</a></li>
                </ul>
              </li>    
                  {{--       @endcan --}}
                  {{--      @can('showAllSalary') --}}
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                 工资 <b class="caret"></b>
                </a>  
                <ul class="dropdown-menu">      
                    <li><a href="">月工资表</a></li>
                    <li><a href="/bumen">月部门</a></li>
                    <li><a href="/byear/2018/">分部汇总</a></li>
                    <li><a href="/myear/2018/">分月汇总</a></li>
                    <li><a href="/geren">个人</a></li>
                    <li><a href="/phb">封神榜</a></li>     
                    <li class="divider"></li>
                </ul>
              </li>

               {{--        @endcan    --}} 
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                {{ \Auth::check()?Auth::user()->name:"" }} <b class="caret"></b>
              </a>
               @if (\Auth::check())
              <ul class="dropdown-menu">  
                <li><a href="{{ route('edit') }}">修改密码</a></li>
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
      </nav>
      @endauth
    </div>
  </div>
</header>
