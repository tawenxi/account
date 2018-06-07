@extends('layouts.default')
@section('title','缓存监控台')
@section('content')


<h1>缓存监控台({{ count($updatedZfpzs) }})</h1>

<article id="app">
    <div  class='h4 row'>
    <table class="table table-dark table-bordered table-striped table-condensed table-sm table-hover">
        <caption>
            <center>{{ date("Y-m-d H:i:s") }}</center>
        </caption>

        <thead>
            <tr class='success'>
              
                <th>制单日期</th>
                <th>日期</th>
                <th>摘要</th>
                <th>收款人</th>
                <th>预算单位</th>
                <th>总金额</th>
                <th>支出类型</th>
                <th>支出类型</th>


            </tr>
        </thead>
        <tbody class='alert-hover'>
           
               @if ($updatedZfpzs)
                    @foreach ($updatedZfpzs as $zfpz)
                     <tr>
                    <td class="alert-danger">
                         {{ $zfpz['PDRQ'] }}
                    </td>
                    <td class="alert-success">
                        {{ $zfpz['QS_RQ'] }}
                    </td>
                    <td>
                             {{ $zfpz['ZY'] }}
                    </td>
                    <td >
                         {{ $zfpz['SKR'] }}
                    </td>
                    <td>
                         {{ $zfpz['YSDWMC'] }}
                    </td>
                    <td>
                         {{ div($zfpz['JE']/100) }}
                    </td>
                    <td>
                         {{ $zfpz['ZFFSMC'] }}
                    </td>   

                    <td>
                         <div class="btn {{ $class = \App\Model\Zfpz::where('PDH',$zfpz['PDH'])->value('QS_RQ')?'btn-success':'btn-primary' }}">
                             {{ \App\Model\Zfpz::where('PDH',$zfpz['PDH'])->value('QS_RQ')?'已清算':'已审核' }}
                         </div>
                    </td>  
                </tr>  
                 @endforeach 
               @endif
        
        </tbody>
        <tr class='success'>
            <th>制单日期</th>
            <th>日期</th>
            <th>摘要</th>
            <th>收款人</th>
            <th>预算单位</th>
            <th></th>
            <th>支出类型</th>
            <th>支出类型</th>


        </tr>
        
        {{-- {{ $results->appends(['sort' => 'votes'])->links() }} --}}
    </table>
            <hr>
    </div>
</article>


<article id="app">
    <div  class='h4 row'>
    <table class="table table-dark table-bordered table-striped table-condensed table-sm table-hover">
        <caption>
            <center>{{ date("Y-m-d H:i:s") }}</center>
        </caption>

        <thead>
            <tr class='success'>
              
                <th>指标ID</th>
                <th>日期</th>
                <th>摘要</th>
                <th>预算项目</th>
                <th>总金额</th>
                <th>单位</th>
            </tr>
        </thead>
        <tbody class='alert-hover'>
           @if ($updatedZbs)
               @foreach ($updatedZbs as $zb)
                     <tr>

                    <td class="alert-success">
                        {{ $zb['ZBID'] }}
                    </td>
                    <td>
                             {{ $zb['LR_RQ'] }}
                    </td>
                    <td >
                         {{ $zb['ZY'] }}
                    </td>
                    <td>
                         {{ $zb['ZJXZMC'] }}
                    </td>
                    <td>
                         {{ div($zb['JE']/100) }}
                    </td>
                    <td>
                         {{ $zb['YSDWMC'] }}
                    </td>   


                </tr>  
                 @endforeach 
           @endif
                
        
        </tbody>
        <tr class='success'>
                <th>指标ID</th>
                <th>日期</th>
                <th>摘要</th>
                <th>预算项目</th>
                <th>总金额</th>
                <th>单位</th>

        </tr>
        {{-- {{ $results->appends(['sort' => 'votes'])->links() }} --}}
    </table>
            <hr>
    </div>
</article>
@stop

@section('js')

@stop


