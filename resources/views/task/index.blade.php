<!DOCTYPE html>
<html>
<head>
  <title>Todo list - Vue.js</title>    
  <meta name="viewport" content="width=device-width" />
  <link rel="icon" href="/image/favicon.png" sizes="32x32">
  <link rel="stylesheet" type="text/css" href="/task/css/styles.css">
  <link rel="stylesheet" href="/task/css/app.css">
  <link href="/task/css/bs3.css" rel="stylesheet">
  <script src="/task/js/vue.js"></script>

  <!-- Global site tag (gtag.js) - Google Analytics -->

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

      <form @keydown.enter.prevent="">
        <div class="form-group">
          <input type="text" class="form-control" v-bind:class="{ active: new_todo }" placeholder="摘要" v-model="new_todo.ZY" ref='ZY'>
        </div><!-- v-on:keyup.enter="addItem" -->
        <div class="form-group">
          <input type="text" class="form-control" v-bind:class="{ active: new_todo }" placeholder="金额" v-model="new_todo.amount" >
        </div>
        <span style="color: red">  @{{note}}</span>
        <div class="form-group">
        <input type="text" class="form-control" v-bind:class="{ active: new_todo }" placeholder="收款人" v-model="new_todo.SKR" 
          v-on:keyup.enter="findSkr(new_todo.SKR)">
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
        <option value="授权" selected="selected">授权</option>
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

      </form>

      <div v-if="pending.length > 0">
        <h3  style="text-align: center;">You have @{{ pending.length }} pending item<span v-if="todoList.length>1">s</span></h3>
        <transition-group name="todo-item" tag="ul" class="todo-list">
          <li v-for="(item, index) in pending" v-bind:key="item.ZY"
          :id="[item.tagged?'tagged':(item.ZFFS == '授权')?'zhijie':'shouquan']">
            <input class="todo-checkbox" v-bind:id="'item_' + item.id" v-model="item.done" type="checkbox">
            <label v-bind:for="'item_' + item.id"></label>
            <div class="row">
            <span class="col-md-2"  @dblclick="editTask(item)">@{{item.ZY}}</span>
            <span class="col-md-2" @dblclick="tag(item)"><span class="text-danger">|</span>@{{item.amount}}
            <button v-show='item.beizhu' id="gg" >&#10004;</button> </span>
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
        <transition-group name="todo-item" tag="ul" class="todo-list">
          <li v-for="(item, index) in completed" v-bind:key="item.ZY" 
          :id="[item.tagged?'tagged':(item.ZFFS == '授权')?'zhijie':'shouquan']">
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
      </div>

    </section>

  </div>

 
  <script async defer src="/task/js/buttons.js"></script>
</body>

<script src="/task/js/resource.js"></script>
<script src="/task/js/app.js" type="text/javascript" ></script>