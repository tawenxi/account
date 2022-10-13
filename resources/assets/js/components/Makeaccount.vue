<template>
  <div>
      <v-select  v-model="selected" :options="options"></v-select>
     
       <input type="hidden" v-bind:name="zfpz" v-model="selected.id">
  </div>
  
 
</template>

<script>

  export default {
    props:['account','zfpz'],
    data() {
      return {
        value: {
    default: null
    },
        options: this.account,
        selected: {id: 0, label: '请输入科目关键字'}
      }
    },

    mounted(){

    }
  }
</script>