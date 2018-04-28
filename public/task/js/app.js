Vue.use(VueResource);

  new Vue({
  el: '#app',
  data() {
    return {
      error:false,
      todoList: [],
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
  },
  watch: {
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
      return this.todoList.filter(function(item) {
        return !item.done;
      })
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
      //console.log(that)
      this.$http.get('http://account.test/api/validate').then(response => {    
                  var res = response.data.filter(function(item){
                      return that.ZY+that.amount+that.SKR == item.ZY+(item.JE/100)+item.SKR;  
                  });
                  //console.log(res)
                  if (res[0]) {
                      that.error=true;
                      alert('可能以前做了一样的单子')
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
                    // console.log($$item)
                    that.deleteItem($$item)
                  });
            });    
      });
  },


    autoQs() {
      alert('haha2');
    },

    tag(task) {
      task.tagged = !task.tagged
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
      }
    },
    // add a new item
    addItem() {
      this.validate()
      // validation check
      if (this.new_todo.ZY) {
        this.todoList.unshift({
          id: this.todoList.length?((this.todoList.sort(function($item){
                                return $item.id
                              }).reverse()[0].id)+1):1,
          ZY: this.new_todo.ZY,
          amount: this.new_todo.amount,
          SKR: this.new_todo.SKR,
          SKYH: this.new_todo.SKYH,
          SKZH: this.new_todo.SKZH,
          ZFFS: this.new_todo.ZFFS,
          label: Date.parse(new Date()),
          tagged: 0,
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
    }
  },
});