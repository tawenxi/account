<!doctype html>

    <head>

    </head>
    <body >
	    <div id="app">
	    	<div class="container" >
               <Mychart :labels="['Jan','Feb','Mar']" 
               			:values="[100,400,100]"
               			> 
               	</Mychart>	
        </div>


        <div class="container" >
               <Mychart :labels="['April','May','Jan']" 
               			:values="[300,100,300]"
               			color="red"
               			> 
               	</Mychart>	
        </div>	
	    </div>
        
        <script src={{ asset('js/appss.js') }}></script>
    </body>
</html>
