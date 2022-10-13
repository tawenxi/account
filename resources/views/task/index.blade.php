<!DOCTYPE html>
<html>
<head>
  <title>Todo list - Vue.js</title>    
  <meta name="viewport" content="width=device-width" />
  <link rel="icon" href="/image/favicon.png" sizes="32x32">
  <link rel="stylesheet" type="text/css" href="/task/css/styles.css">
  <link rel="stylesheet" href="/task/css/app.css">
  <link href="/task/css/bs3.css" rel="stylesheet">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-39432248-2');
  </script>

</head>

<body>
  <div id="app">
    <h1>财务任务管理器</h1>
    <section class="todo-wrapper">
      <h2 class="todo-title">@{{ today.day }}<br>@{{ today.date }}</h2>

{{--       <pre>
        @{{ todoList }}
      </pre> --}}
      <table class="table table-hover" v-if="Zfpz[0]">
        <thead>
          <tr>
            <th class="col-md-3">日期</th><th class="col-md-3">摘要</th><th class="col-md-3">金额</th><th class="col-md-3">生效时间</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="pz of Zfpz" :key="pz.id">
            <td>@{{ pz.PDRQ }} </td><td>@{{ pz.ZY }}</td><td> @{{ pz.JE/100 }}</td><td> @{{ pz.QS_RQ }}</td>
          </tr>
        </tbody>
      </table>

      <form @keydown.enter.prevent="">
        <div class="form-group">
          <input type="text" class="form-control" v-bind:class="{ active: new_todo }" placeholder="摘要" v-model="new_todo.ZY" ref='ZY'>
        </div><!-- v-on:keyup.enter="addItem" -->
        <div class="form-group">
          <input type="text" class="form-control" v-bind:class="{ active: new_todo }" placeholder="金额" v-model="new_todo.amount" >
        </div>
        <div class="form-group">
        <v-select v-model="selected" :options="options"></v-select>  
        </div>
        <div class="form-group">
        <input type="text" class="form-control" v-bind:class="{ active: new_todo }" placeholder="自写收款人" v-model="new_todo.SKR" >
        </div>
        <div class="form-group">
        <input type="text" class="form-control" v-bind:class="{ active: new_todo }" placeholder="收款账号" v-model="new_todo.SKZH" >
        </div>
        <div class="form-group">
        <input type="text" class="form-control" v-bind:class="{ active: new_todo }" placeholder="收款银行" v-model="new_todo.SKYH" >
        </div>
        <div class="form-group">
   <!--      <input type="text" class="form-control" v-bind:class="{ active: new_todo }" placeholder="支付方式" v-model="new_todo.ZFFS" v-on:keyup.enter="addItem"> -->
        
       <select v-model="new_todo.ZFFS" class="form-control"  >
        <option value="待定" selected="selected">待定</option>

        <option value="授权" >授权</option>
        <option value="直接" >直接</option>
      </select>
      </div>
      <div class="form-group">
        <input type="text" class="form-control" v-bind:class="{ active: new_todo }" placeholder="备注" v-model="new_todo.beizhu" v-on:keyup.enter="addItem" >
        </div>
  
        
        <br>
        <div class="btn btn-add" v-bind:class="{ active: true }"  @click="addItem">增加任务</div>
        <div class="btn btn-add btn-success" v-bind:class="{ active: true }"  @click="autoCompleted">自动完成</div>
        <div class="btn btn-add btn-primary" v-bind:class="{ active: true }"  @click="autoPass">自动清算</div>
        <hr>
        <div class="btn btn-add btn-danger" v-bind:class="{ active: true }"  @click=setorderkey('tagged')>显示标记</div>
        <div class="btn btn-add btn-success" v-bind:class="{ active: !savesuccess }"  @click=savedata()>保存数据</div>
        <div class="btn btn-add btn-primary" v-bind:class="{ active: true }"  @click=getdata()>恢复数据</div>



      </form>

      <div v-if="pending.length > 0">
        <h3  style="text-align: center;">You have @{{ pending.length }} pending item<span v-if="todoList.length>1">s</span></h3>

        <h3  style="text-align: center;">You have @{{ completed.length }} monitered item<span v-if="todoList.length>1">s</span></h3>

        <h3  style="text-align: center; color:red">@{{ Math.round(pendingTotle * 100) / 100 }}</h3>

            <li class="list-group-item list-group-item-success glyphicon-th-list">
                <span class="col-md-2"  @click=setorderkey('ZY')>摘要</span>
              <span class="col-md-2" @click=setorderkey('amount')>金额</span>
              <span class="col-md-2" @click=setorderkey('SKR')>收款人</span>

              <span class="col-md-2" @click=setorderkey('SKZH')>收款账号</span>
              <span class="col-md-2" @click=setorderkey('SKYH')>开户银行</span>
              <span class="col-md-1" @click=setorderkey('label')>时间</span>
            </li>


        <transition-group name="todo-item" tag="ul" class="todo-list">
          <li v-for="(item, index) in pending" v-bind:key="item.id"
          :id="[item.tagged?'tagged':((item.ZFFS == '待定')?'':((item.ZFFS == '直接')?'zhijie':'shouquan'))]">
            <input class="todo-checkbox" v-bind:id="'item_' + item.id" v-model="item.done" type="checkbox">
            <label v-bind:for="'item_' + item.id"></label>
            <div class="row">
            <span class="col-md-2"  @dblclick="editTask(item)">@{{item.ZY}}</span>
            <span class="col-md-2" @dblclick="tag(item)"><span class="text-danger">|</span>@{{item.amount}}
            <button v-show='item.beizhu' id="gg"  v-bind:title="item.beizhu">&#10004;</button> </span>
            <span class="col-md-2"><span class="text-danger">|</span>@{{item.SKR}}</span>
            <span class="col-md-2"><span class="text-danger">|</span>@{{item.SKZH}}</span>
            <span class="col-md-2"><span class="text-danger">|</span>@{{item.SKYH}}</span>
            <span class="col-md-1"><span class="text-danger">|</span >@{{item.label}}</span>
          </div>
            <span class="delete" @click="deleteItem(item)"></span>
          </li>
        </transition>  
      </div> 

      <transition name="slide-fade">
        <p class="status free" v-if="!pending.length" ><img src="/image/beer_celebration.svg" alt="celebration">Time to chill!  You have no todos.</p> 
      </transition> 

      <div v-if="completed.length > 0 && showComplete">
        <h3 style="text-align: center;">Completed tasks: @{{ completedPercentage }}</h3>
        <h3  style="text-align: center; color:red">@{{ completedTotle }}</h3>
        <transition-group name="todo-item" tag="ul" class="todo-list">
          <li v-for="(item, index) in completed" v-bind:key="item.id" 
          :id="[item.tagged?'tagged':((item.ZFFS == '待定')?'':((item.ZFFS == '直接')?'zhijie':'shouquan'))]">
            <input class="todo-checkbox" v-bind:id="'item_' + item.id" v-model="item.done" type="checkbox">
            <label v-bind:for="'item_' + item.id"></label>
             <div class="row">
            <span class="col-md-2" @dblclick="editTask(item)">@{{item.ZY}}</span>
            <span class="col-md-2"><span class="text-danger" @dblclick="tag(item)">|</span>@{{item.amount}}
            <button v-show='item.beizhu' id="gg" v-bind:title="item.beizhu">&#10004;</button></span>
            <span class="col-md-2"><span class="text-danger">|</span>@{{item.SKR}}</span>
            <span class="col-md-2"><span class="text-danger">|</span>@{{item.SKZH}}</span>
            <span class="col-md-2"><span class="text-danger">|</span>@{{item.SKYH}}</span>
            <span class="col-md-1"><span class="text-danger">|</span>@{{item.label}}</span>
                
          </div>
            <span class="delete" @click="deleteItem(item)"></span>
          </li>
        </transition>  
      </div>
      <div class="control-buttons">
        <div class="btn btn-success btn-secondary" v-if="completed.length > 0" @click="toggleShowComplete"><span v-if="!showComplete">Show</span><span v-else >Hide</span> Complete</div>
        <div class="btn btn-secondary btn-danger" v-if="todoList.length > 0" @click="clearAll">Clear All</div>
        <div class="btn btn-secondary btn-primary" v-if="todoList.length > 0" @click="untagAll">Untag All</div>
      </div>
    </section>
  </div>
  <script src="/js/task.js?t="<?=time()?> type="text/javascript" ></script>
</body>

