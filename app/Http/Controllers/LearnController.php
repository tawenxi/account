<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Mail\SendcloudMail;
use App\Repositories\ZbRepository;
use App\Repositories\ZfpzRepository;
use Carbon\Carbon;

class LearnController extends Controller
{
    public function index()
    {
    	$users = User::where('id','<','6')->get();
    	foreach ($users as $user) {
    		dispatch(new \App\Jobs\Myjob($user));
    	}
    	
    	echo 'done';
    }


        public function index2(ZfpzRepository $repository_zfpz,
                                ZbRepository $repository_zb)
    {

    	$headers = ['LR_RQ', 'ZY', 'JE'];
        $date = 10;
        $zb = $repository_zb->findwhere([['LR_RQ','>=',$date]],$headers);


        // $headers = ['QS_RQ', 'ZY', 'JE','SKR'];
        // $table = $repository_zfpz->findwhere([['QS_RQ','>=',$date]],$headers)->toarray();
        // $this->info($date.'发生的支出');
        // $this->table($headers, $table);


          $useremail = 'tawenxi@qq.com';

        \Mail::to($useremail)->send(new SendcloudMail($zb)); //StarterMail为第3步创建的邮件类
    	echo 'done';
    }


    function index3 ()
    {
        
    }

        function index5 ()
    {
       
    }
}
