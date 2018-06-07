@extends('layouts.default')
@section('title','监控台')
@section('content')


<h1>监控台</h1>

<article id="app">
    <div  class='h4 row'>
    <table class="table table-dark table-bordered table-striped table-condensed table-sm table-hover">
        <caption>
            <center>{{ date("Y-m-d H:i:s") }}</center>
        </caption>

        <thead>
            <tr class='bg-primary'>
              
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
        <tbody class='table-hover'>
           
                <tr v-for="zfpz in zfpzs">



                    <td class="alert-danger">
                         @{{ zfpz.PDRQ }}
                    </td>
                    <td class="alert-success">
                        @{{ zfpz.QS_RQ }}
                    </td>
                    <td>
                        
                             @{{ zfpz.ZY }}
                      
                    </td>
                    <td >
                         @{{ zfpz.SKR }}
                        
                    </td>
                    <td>
                         @{{ zfpz.YSDWMC }}
                    </td>
                    <td>
                         @{{ zfpz.JE }}
                    </td>
                    <td>
                         @{{ zfpz.ZFFSMC }}
                    </td>   

                    <td>
                         <div :class=zfpz.class >
                             @{{  zfpz.LX }}
                         </div>
                    </td>  


                </tr>   
        
        </tbody>
        <tr class='bg-primary'>
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
            <tr class='bg-primary'>
              
                <th>指标ID</th>
                <th>日期</th>
                <th>摘要</th>
                <th>预算项目</th>
                <th>总金额</th>
                <th>单位</th>
          

            </tr>
        </thead>
        <tbody class='alert-hover'>
           
                <tr v-for="zb in zbs">

                    <td class="alert-success">
                        @{{ zb.ZBID }}
                    </td>
                    <td>
                        
                             @{{ zb.LR_RQ }}
                      
                    </td>
                    <td >
                         @{{ zb.ZY }}
                        
                    </td>
                    <td>
                         @{{ zb.ZJXZMC }}
                    </td>
                    <td>
                         @{{ zb.JE }}
                    </td>
                    <td>
                         @{{ zb.YSDWMC }}
                    </td>   


                </tr>   
        
        </tbody>
        <tr class='bg-primary'>
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

