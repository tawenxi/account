<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function session(){

	    switch (session('ND')) {
	    	case '2018':
	    		session(['ND'=>'2017']);
	    		break;
	    	case '2017':
	    		session(['ND'=>'2016']);
	    		break;	
	    	case '2016':
	    		session(['ND'=>'2018']);
	    		break;	     	
	    	default:
	    		session(['ND'=>'2018']);
	    		break;
	    }

	    session()->flash('z-turbolinks','session');
	    return back();
    
	}
}
