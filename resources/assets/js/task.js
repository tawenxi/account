require('./bootstrap');
require('select');
window.Vue = require('vue');
import VueSelect from 'vue-select';

//Vue.use(VueResource);
Vue.prototype.$http = axios;
Vue.component('v-select', VueSelect);
  new Vue({
  el: '#app',
  data() {
    return {
      savesuccess:false,
      ordercolumn:'label',
      reverse:true,
      options: [],
      selected: {id: 9999999, label: '请输入收款人关键字'},
      error:false,
      todoList: [],
      Zfpz:[],
      new_todo:{"id":0,
                "ZY":"",
                'amount':'',
                'SKR':'',
                'SKZH':'',
                'SKYH':'',
                'ZFFS':'',
                'label':'',
                'beizhu':'',
                'tagged':false,
                "done":false,
        },
      showComplete: false,
      note:'',

    };
  },
  mounted() {
    this.getTodos();
    this.$http.get('http://account.test/api/allboss').then(response => {
    if (response.data[0]) {
      this.options = response.data;
    }  
});

  },
  watch: {
    'selected':function(){
      this.new_todo.SKR = this.selected.label;
      this.Zfpz=[]
      if (this.selected.id != 9999999) {
        this.findSkr(this.selected.label)
      }

      this.$http.get('http://account.test/api/zfpzs'+'/'+this.new_todo.SKR).then(response => {
         
            if (response.data[0]) {
              this.Zfpz = response.data;
              console.log(this.Zfpz)
            }  
        });
    },
    todoList: {
      handler: function(updatedList) {
        localStorage.setItem('todo_list', JSON.stringify(updatedList));
      },
      deep: true
    }
  },
  computed:{
    pendingTotle: function() {
      return this.sum(this.pending)
    },

    completedTotle: function() {
      return this.sum(this.completed)
    },

    pending: function() {
      let orderedList = this.todoList.filter(function(item) {
        return !item.done;
      })

      return this.order(orderedList,this.ordercolumn,this.reverse)
    },
    completed: function() {
      return this.todoList.filter(function(item) {
        return item.done;
      }); 
    },
    completedPercentage: function() {
      return (Math.floor((this.completed.length / this.todoList.length) * 100)) + "%";
    },
    today: function() {
      var weekday = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
      var today = new Date();
      var dd = today.getDate();
      var mm = today.getMonth()+1; //January is 0!
      var yyyy = today.getFullYear();

      if(dd<10) {
          dd = '0'+dd
      } 

      if(mm<10) {
          mm = '0'+mm
      } 

      today = {
        day: weekday[today.getDay()],
        date:  mm + '-' + dd + '-' + yyyy,
      }

      return(today);
    }
  },
  methods: {

    savedata(){
      var totle = 0
      this.$http.get('/api/truncatedata');
      this.todoList.forEach((item) => {
          this.$http.post('/api/savedata',item).then(response =>{
           
              totle++
              console.log(totle)
              if (this.todoList.length == totle) { 
                  this.savesuccess = true
                  console.log('ok')
              }

            
          });
        });

    },

    getdata(){
          this.$http.get('/api/getdata').then(response => {
              this.todoList = response.data
          });
    },

    sum(arr) {
      var s = 0;
      arr.forEach(function(val, idx, arr) {
          s += val.amount*1;
      });
    
      return s;
    },

    validate(){
      this.error = false;
      var that = this.new_todo;
      var $result = this.todoList.find((item, index, arr) => {
        return item.ZY == this.new_todo.ZY && item.amount == this.new_todo.amount && item.SKR == this.new_todo.SKR;
      });

      if ($result) {
        this.error = true;
        alert('在任务菜单中有此项目！！')
      }
      this.$http.get('http://account.test/api/validate').then(response => {    
                  var res = response.data.filter(function(item){
                      return that.ZY+that.amount+that.SKR == item.ZY+(item.JE/100)+item.SKR;  
                  });

                  if (res[0]) {
                      that.error=true;
                      alert('以前做了一样的单子')
                   }

                  var res2 = response.data.filter(function(item){
                     return that.ZY+that.SKR == item.ZY+item.SKR;  
                  });
                  if (res2[0]) {
                      that.error=true;
                      alert('可能以前做了一样的单子,但是金额不准确')
                   }
      });
    },
    editTask(task){
      this.deleteItem(task);
      this.new_todo = task;
      this.$refs.ZY.focus();
    },


    autoCompleted() {

      var that = this;
            this.$http.get('http://account.test/api/unshengxiao').then(response => {
            response.data.forEach(function(item,index){
                  var a = that.todoList.filter(function($item){
                      //return $item.ZY+$item.amount+$item.SKR == item.ZY+(item.JE/100)+item.SKR;
                      return $item.ZY+$item.SKR == item.ZY+item.SKR;
                  }).forEach(function($$item){
                    $$item.done = true
                  });
            });    
      });
    },


  autoPass() {

      var that = this;
            this.$http.get('http://account.test/api/shengxiao').then(response => {
            response.data.forEach(function(item,index){
                  var a = that.todoList.filter(function($item){
                      return $item.ZY+$item.amount+$item.SKR == item.ZY+(item.JE/100)+item.SKR;
                  }).forEach(function($$item){

                    that.deleteItem($$item)
                  });
            });    
      });
  },


    autoQs() {
      alert('haha2');
    },


    setorderkey(key){
      this.reverse = (this.ordercolumn == key)? !this.reverse : true
       this.ordercolumn = key
    },


    order(list,ordercolumn,reverse){
        if (!this.reverse) {
        return _.sortBy(list,ordercolumn)
       }
      return _.sortBy(list,ordercolumn).reverse()
    },

    untagAll(){
      this.todoList.forEach(function(item){
         item.tagged = false;
      });
    },

    tag(task) {
      task.tagged = !task.tagged;
      //this.order();
    },
    findSkr(data) {
      this.note = '';
      this.$http.get('http://account.test/api/boss'+'/'+data).then(response => {
        console.log(response.data.bankaccount)
        if (response.data.bankaccount) {
          this.new_todo.SKZH = response.data.bankaccount;
          this.new_todo.SKYH = response.data.bank;
        } else {
          this.note = '没有找到收款人';
        }
        
      });
    },
    // get all todos when loading the page
    getTodos() {
      if (localStorage.getItem('todo_list')) {
        this.todoList = JSON.parse(localStorage.getItem('todo_list'));
        this.todoList.forEach(function(item){
            item.amount = parseFloat(item.amount);
        });
        //this.order();
      }
    },
    // add a new item
    addItem() {
      this.validate()
      // validation check
      if (this.new_todo.ZY) {
        this.todoList.unshift({
          id: this.todoList.length?(_.maxBy(this.todoList, 'id').id + 1):1,
          ZY: this.new_todo.ZY,
          amount: parseFloat(this.new_todo.amount),
          SKR: this.new_todo.SKR,
          SKYH: this.new_todo.SKYH,
          SKZH: this.new_todo.SKZH,
          ZFFS: this.new_todo.ZFFS,
          label: Date.parse(new Date())/1000-1500000000,
          tagged: false,
          beizhu: this.new_todo.beizhu,
          done: false,
        });
      }
      // reset new_todo
      this.new_todo = {"id":0,
                "ZY":"",
                'amount':'',
                'SKR':'',
                'SKZH':'',
                'SKYH':'',
                'ZFFS':'',
                'label':'',
                'beizhu':'',
                'tagged':false,
                "done":false,
        };
        this.selected = {id: 9999999, label: '请输入收款人关键字'}
        this.$refs.ZY.focus();
      // save the new item in localstorage
      return true;
    },
    deleteItem(item) {
      this.todoList.splice(this.todoList.indexOf(item), 1);
    },
    toggleShowComplete() {
      this.showComplete = !this.showComplete;
    },
    clearAll() {
      this.todoList = [];
    },
    fmtDate(obj){
    var date =  new Date(obj);
    var y = 1900+date.getYear();
    var m = "0"+(date.getMonth()+1);
    var d = "0"+date.getDate();
    return m.substring(m.length-2,m.length)+"-"+d.substring(d.length-2,d.length);
    }
  },
});