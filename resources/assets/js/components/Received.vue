<template>
 
    <button
        class="btn btn-default"
        v-bind:class="{'btn-success': received}"
        v-text="text"
        v-on:click="receive"
    >
    </button>
</template>

<script>
    export default {
        props:['zfpz','is_received'],
        data() {
            return {
                received: 0
            }
        },

        computed: {
            text() {
                return (this.received == 1) ? '已收到' : '请核票'
            }
        },
        mounted() {
            this.received = this.is_received;  
        },

        methods:{
            receive() {
                this.$http.post('/api/zfpz/receive',{'zfpz':this.zfpz}).then(response => {
                    console.log(response.data);
                    this.received = response.data.received
                });
            }
        }
    }
</script>
