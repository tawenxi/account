
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
Vue.prototype.$http = axios;
import VueClipboard from 'vue-clipboard2';
import VueResource from 'vue-resource';
import vSelect from 'vue-select';
import TurbolinksAdapter from 'vue-turbolinks';
import CxltToastr from 'cxlt-vue2-toastr';
import 'cxlt-vue2-toastr/dist/css/cxlt-vue2-toastr.css';

Vue.use(VueClipboard);
Vue.use(VueResource);
Vue.use(TurbolinksAdapter);

var toastrConfigs = {
    position: 'top right',
    showDuration: 2000,
    timeOut: 20000,
}
Vue.use(CxltToastr, toastrConfigs);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('Example', require('./components/Example.vue'));
Vue.component('Mychart', require('./components/Mychart.vue'));
Vue.component('Received', require('./components/Received.vue'));
Vue.component('v-select', vSelect);
Vue.component('Vselect', require('./components/Vselect.vue'));
Vue.component('Makeaccount', require('./components/Makeaccount.vue'));


document.addEventListener('turbolinks:load', () => {
	const app = new Vue({
    	el: '#app',
    	data() {
            return {
                zfpzs:[],
                zbs:[],
                shouldHidden:true,
                hiddenId :[],
                coloredId :[],
            }
        },

        methods:{
             doCopy: function ($guzzleid) {
                this.$copyText($guzzleid).then(function (e) {
                  alert('已复制'+$guzzleid)
                  console.log(e)
                }, function (e) {
                  alert('Can not copy')
                  console.log(e)
                })
            },
            hidden(id) {
                this.shouldHidden = false;
                this.hiddenId.push(id);
            },
            colored(id) {
                if (this.isColorMe(id)) {
                    for (var i = 0; i < this.coloredId.length; i++){
                        if (this.coloredId[i] == id)  this.coloredId.splice(i,1);
                    }
                } else {
                    this.coloredId.push(id);
                }
            },

            isHiddenMe(id) {
                for (var i = 0; i < this.hiddenId.length; i++){
                if (this.hiddenId[i] == id)//如果要求数据类型也一致，这里可使用恒等号===
                    return false;
                }
                return true;
            },
            isColorMe(id) {
                for (var i = 0; i < this.coloredId.length; i++){
                if (this.coloredId[i] == id)//如果要求数据类型也一致，这里可使用恒等号===
                    return true;
                }
                return false;
            },

            getCookie(name){
                var strcookie = document.cookie;//获取cookie字符串
                var arrcookie = strcookie.split("; ");//分割
                //遍历匹配
                for ( var i = 0; i < arrcookie.length; i++) {
                var arr = arrcookie[i].split("=");
                if (arr[0] == name){
                return arr[1];
                }
                }
                return "";
            },
        },

    	mounted() {
            console.log(this.getCookie('iscached'));
            console.log(1);
            if (this.getCookie('iscached') == 1) {
                this.$toast.info({title:'缓存状态',message:'已缓存'});
            } else {
                this.$toast.error({title:'缓存状态',message:'无缓存'});
            }
            this.$toast.success({title:'加油吧！Tawenxi',message:''});
            // toastr.options.closeButton = true;
            // toastr.options.closeHtml = '<button><i class="icon-off">LOVE</i></button>';
            // toastr.options.onShown = function() { console.log('hello'); }
            // toastr.options.onHidden = function() { console.log('goodbye'); }
            // toastr.options.onclick = function() { console.log('clicked'); }
            // toastr.options.onCloseClick = function() { console.log('close button clicked'); }
            // toastr.info('欢迎来到监控台');
            // toastr.success('Have fun storming the castle!', 'Miracle Max Says');
            // toastr.success('加油吧.', 'tawenxi', {timeOut: 5000000000});

            let socket = io('http://127.0.0.1:3000');
            socket.on('updatenewpass',function(data){
                if (data.LX == '已清算'){
                    console.log(data.LX);
                    data.class = 'btn btn-success';
                    this.$toast.success({title:'清算成功',message:''});
                    data.JE = data.JE/100;
                    this.zfpzs.push(data);
                } 
                if (data.LX == '收到新指标') {
                    this.$toast.error({title:'更新收入成功',message:''});
                    data.JE = data.JE/100;
                    this.zbs.push(data);
                }

                if (data.LX == '已审核') {
                    data.class = 'btn btn-primary';
                    data.JE = data.JE/100;
                    this.$toast.info({title:'审核成功了',message:''});
                    this.zfpzs.push(data);
                }

                
                console.log(this.zfpzs);
                this.zfpzs.sort(function(x, y){
                  return x[0];
                });
            }.bind(this));
        }
	});


    const app2 = new Vue({
        el: '#navtop',
        data() {
            return {
                zfpzs:[],

            }
        },

        methods:{
            cacheclear(){
                this.$http.get('/api/cacheclear').then(response => {
                    console.log(response.data.cacheclear);
                    if (response.data.cacheclear) {
                        this.$toast.info({title:'清除缓存：',message:'清除成功'});
                    }
                });
            },

            pullzfpz(){
                this.$http.get('/api/pullzfpz').then(response => {
                    console.log('更新指标和支付令成功'+response.data.pullzfpz);
                    if (response.data.pullzfpz) {
                        this.$toast.success({title:'后台执行：',message:'更新指标和支付令成功'});
                    }
                });
            },
            pullsq(){
                this.$http.get('/api/pullsq').then(response => {
                    console.log('更新授权指标成功'+response.data.pullsq);
                    if (response.data.pullsq) {
                        this.$toast.success({title:'后台执行：',message:'更新授权指标成功'});
                    }
                });

            },
            pullzj(){
                this.$http.get('/api/pullzj').then(response => {
                    console.log('更新授权指标成功'+response.data.pullzj);
                    if (response.data.pullzj) {
                        this.$toast.success({title:'后台执行：',message:'更新直接指标成功'});
                    }
                });
            },
            updateboss(){
                this.$http.get('/api/updateboss').then(response => {
                    console.log('更新授权指标成功'+response.data.updateboss);
                    if (response.data.updateboss) {
                        this.$toast.success({title:'后台执行：',message:'更新BOSS成功'});
                    }
                });
            },
            pullyue(){
                this.$http.get('/api/pullyue').then(response => {
                    console.log('更新授权指标成功'+response.data.pullyue);
                    if (response.data.pullyue) {
                        this.$toast.success({title:'后台执行：',message:'更新指标余额成功'});
                    }
                });

            },
            pullshenqing(){
                this.$http.get('/api/pullshenqing').then(response => {
                    console.log('更新授权指标成功'+response.data.pullshenqing);
                    if (response.data.pullshenqing) {
                        this.$toast.success({title:'后台执行：',message:'更新分月申请成功'});
                    }
                });
            },
            pullcast(){
                this.$http.get('/api/pullcast').then(response => {
                    console.log('更新授权指标成功'+response.data.pullcast);
                    if (response.data.pullcast) {
                        this.$toast.success({title:'后台执行：',message:'更新分月申请成功'});
                    }
                });
            },

            pulldpt(){
                this.$http.get('/api/pulldpt').then(response => {
                    console.log('更新DPT成功'+response.data.pulldpt);
                    if (response.data.pulldpt) {
                        this.$toast.success({title:'后台执行：',message:'更新DPT成功'});
                    }
                });
            },
        }
    });
});



