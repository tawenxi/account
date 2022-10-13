<template>
   <!--  <canvas width="400" height="400" id="graph"></canvas> -->
    <div>
        <canvas width="1400" height="700" id='graph'></canvas>
        <div class="line-legend" v-html="legend"></div>
    </div>
</template>

<script>

import Chart from 'chart.js';
export default Vue.extend({
	data(){
        return { legend:'' };
    },

    methods:{
        renda(data){
            var context = document.querySelector('#graph').getContext('2d');
            // new Chart(context).Line(data);
            const chart = new Chart(context).Bar(data);
            this.legend = chart.generateLegend();
        }
    },


});

</script>