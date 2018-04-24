
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueResource from 'vue-resource';
Vue.use(VueResource);
import vSelect from 'vue-select';

import TurbolinksAdapter from 'vue-turbolinks';
Vue.use(TurbolinksAdapter);

import CxltToastr from 'cxlt-vue2-toastr';
import 'cxlt-vue2-toastr/dist/css/cxlt-vue2-toastr.css';
var toastrConfigs = {
    position: 'top right',
    showDuration: 20000,
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
            }
        },

    	mounted() {

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
});



