<template>
   <!--  <canvas width="400" height="400" id="graph"></canvas> -->
    <div>
        <canvas width="400" height="400" id='graph'></canvas>
        <div class="line-legend" v-html="legend"></div>
    </div>
</template>

<script>
    import Chart from 'chart.js';
    export default {
        props:{
            labels:{},
            values:{},
            color:{
                default:'rgba(0,220,220,100)'
            }
        },

        data(){
            return { legend:'' };
        },
        //props:['labels','values',''],
        mounted() {
        var data = {
       
          //labels:this.labels,
          labels:this.labels,
          datasets : [
            {
                label:"Monthly point",
                fillColor:this.color,
                strokeColor: "red",
                pointColor: "rgba(220,220,110,1)",
                pointStrokeColor: "#fff",
                PointHighlightStroke: "red",
                data:this.values
            },
            {
                label:"Other point",
                fillColor:'red',
                strokeColor: "rgba(220,220,110,1)",
                pointColor: "rgba(220,220,110,1)",
                pointStrokeColor: "#fff",
                PointHighlightStroke: "rgba(220,220,110,1)",
                data:[21,500,60]
            }

          ]
        };

            var context = document.querySelector('#graph').getContext('2d');

            // new Chart(context).Line(data);
            const chart = new Chart(context).Bar(data);

            this.legend = chart.generateLegend();
        }
    }
</script>
