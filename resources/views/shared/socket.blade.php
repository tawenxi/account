<script src="js/socket.io.slim.js"></script>
<script src="js/vue.min.js"></script>
<script src="js/toastr.min.js"></script>
<script>

    new Vue({
        el: '#app',
        data:{
            zfpzs:[],
            zbs:[]
        },

        ready: function() {
            toastr.options.closeButton = true;
            toastr.options.closeHtml = '<button><i class="icon-off">LOVE</i></button>';
            toastr.options.onShown = function() { console.log('hello'); }
            toastr.options.onHidden = function() { console.log('goodbye'); }
            toastr.options.onclick = function() { console.log('clicked'); }
            toastr.options.onCloseClick = function() { console.log('close button clicked'); }
            toastr.info('欢迎来到监控台');
            toastr.success('Have fun storming the castle!', 'Miracle Max Says');
            toastr.success('加油吧.', 'tawenxi', {timeOut: 5000000000});

            let socket = io('http://127.0.0.1:3000');
            socket.on('updatenewpass',function(data){
                if (data.LX == '已清算'){
                    console.log(data.LX);
                    data.class = 'btn btn-success';
                    toastr.success('清算成功了','', {timeOut: 5000000000});
                    data.JE = data.JE/100;
                    this.zfpzs.push(data);
                } 
                if (data.LX == '收到新指标') {
                    toastr.info('更新收入成功','', {timeOut: 5000000000});
                    data.JE = data.JE/100;
                    this.zbs.push(data);
                }

                if (data.LX == '已审核') {
                    data.class = 'btn btn-primary';
                    data.JE = data.JE/100;
                    toastr.error('审核成功了!!!', '',{timeOut: 5000000000});
                    this.zfpzs.push(data);
                }

                
                console.log(this.zfpzs);
                this.zfpzs.sort(function(x, y){
                  return x[0];
                });
            }.bind(this));
        }
    });



</script>    