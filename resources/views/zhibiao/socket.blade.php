@extends('layouts.default')
@section('title','监控台')
@section('content')


<h1>监控台</h1>

<article id="app">
    <div  class='h4 row'>
    <table class="table table-bordered table-striped table-hover table-condensed">
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

            </tr>
        </thead>
        <tbody class='alert-info'>
           
                <tr v-repeat="zfpz: zfpzs">



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


                </tr>   
        
        </tbody>
        <tr class='success'>
            <th>制单日期</th>
            <th>日期</th>
            <th>摘要</th>
            <th>收款人</th>
            <th>预算单位</th>
            <th></th>
            <th>支出类型</th>

        </tr>
        
        {{-- {{ $results->appends(['sort' => 'votes'])->links() }} --}}
    </table>
            <hr>
    </div>
</article>


<article id="app">
    <div  class='h4 row'>
    <table class="table table-bordered table-striped table-hover table-condensed">
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
        <tbody class='alert-info'>
           
                <tr v-repeat="zb: zbs">

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
<script src="js/vue.min.js"></script>
<script src="js/socket.io.slim.js"></script>

<script src="js/toastr.min.js"></script>
<script>

    new Vue({
        el: '#app',
        data:{
            zfpzs:[],
            zbs:[]
        },

        ready: function() {
            toastr.info('欢迎来到监控台');
            console.log('a');
            console.log('b');
            let socket = io('http://127.0.0.1:3000');
            socket.on('updatenewpass',function(data){
                if (data.LX == 1){
                    toastr.info('更新支出成功');
                    this.zfpzs.push(data);
                } 
                if (data.LX == 2) {
                    toastr.info('更新收入成功');
                    this.zbs.push(data);
                }
                
                console.log(this.zfpzs);
            }.bind(this));
        }
    });



</script>       

@stop


