<script>
import Graph from './Graph.vue';
    export default Graph.extend({
        props:{
            keys:{},
            values:{},
            color:{
                default:'rgba(0,220,220,100)'
            }
        },
        //props:['keys','values',''],
        mounted() {
        this.renda(
            {
              labels:this.keys,
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
                // {
                //     label:"Other point",
                //     fillColor:'red',
                //     strokeColor: "rgba(220,220,110,1)",
                //     pointColor: "rgba(220,220,110,1)",
                //     pointStrokeColor: "#fff",
                //     PointHighlightStroke: "rgba(220,220,110,1)",
                //     data:[21,500,60]
                // }

              ]
            });


        }
    });
</script>
