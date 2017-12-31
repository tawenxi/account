<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function session(){
    	
	    if (session('ND') == (string)(config('app.MYND')-1)) {
	        session(['ND'=>(string)config('app.MYND')]);
	    } else {
	        session(['ND'=>(string)(config('app.MYND')-1)]);
	    }
	    return back();
    
	}
}
