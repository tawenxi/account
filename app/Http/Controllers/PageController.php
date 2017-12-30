<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function session(){
    	
	    if (session('ND') == '2017') {
	        session(['ND'=>'2018']);
	    } else {
	        session(['ND'=>'2017']);
	    }
	    return back();
    
	}
}
