<template>
   <!--  <canvas width="400" height="400" id="graph"></canvas> -->
    <canvas width="400" height="400"></canvas>
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
        //props:['labels','values',''],
        mounted() {
        var data = {
       
          //labels:this.labels,
          labels:this.labels,
          datasets : [
            {
                fillColor:this.color,
                strokeColor: "rgba(220,220,110,1)",
                pointColor: "rgba(220,220,110,1)",
                pointStrokeColor: "#fff",
                PointHighlightStroke: "rgba(220,220,110,1)",
                data:this.values
            }

          ]
        };

            // var context = document.querySelector('#graph').getContext('2d');

            // new Chart(context).Line(data);
            new Chart(
                this.$el.getContext('2d')
            ).Line(data);
        }
    }
</script>
