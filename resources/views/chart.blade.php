<!doctype html>

    <head>
  <style>
      .line-legend span {
      width: 10px;
      height: 10px;
      display: inline-block;
      margin-right: 10px;
  }
  </style>
    </head>
    <body >
	    <div id="app">
	    	<div class="container" >
               <Mychart :keys="{{ $projects->keys() }}" 
               			:values="{{ $projects->values() }}"
          
               			> 
               	</Mychart>	
        </div>

	    </div>
        
        <script src={{ asset('js/app.js') }}></script>
    </body>
</html>
