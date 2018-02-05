<template>
  <div>
      <v-select  v-model="selected" :options="options"></v-select>
       <br>
       <input type="hidden" name="account_id" v-model="selected.id">
  </div>
  
 
</template>

<script>

  export default {
    props:['account'],
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