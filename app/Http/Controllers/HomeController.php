<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Zfpz;
use App\Model\Zb;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }


    public function zbdetail(Request $request)
    {
        $results = Zfpz::search(\Request::get('search'), 0.01, true)->orderBy('PDRQ','desc')->get()->unique();
        return view('guzzle.zbdetail',compact('results'))->render();

    }

    public function zhibiao(Request $request)
    {        
        $results = ZB::search(\Request::get('search'), 0.01, true)->orderBy('LR_RQ','desc')->get()->unique();
        return view('guzzle.zhibiao',compact('results'))->render();
    }


}
