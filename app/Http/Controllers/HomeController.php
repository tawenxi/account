<?php

namespace App\Http\Controllers;

use App\Model\Zb;
use App\Model\Zfpz;
use Illuminate\Http\Request;
use App\Repositories\ZfpzRepository;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $repository;
    public function __construct(ZfpzRepository $repository)
    {
        $this->middleware('auth');
        $this->repository = $repository;
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

    public function zbdetail()
    {
        $results = $this->repository->orderBy('account_number', 'desc')->all()->unique();

        return view('guzzle.zbdetail', compact('results'))->render();
    }

    public function zhibiao(Request $request)
    {
        $results = ZB::search(\Request::get('search'), 0.01, true)->orderBy('LR_RQ', 'desc')->get()->unique();

        return view('guzzle.zhibiao', compact('results'))->render();
    }
}
