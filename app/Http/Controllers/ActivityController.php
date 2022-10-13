<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\User;

class ActivityController extends Controller
{
    public function show(User $user)
    {
    	$activites = $user->getActivities();
    	return view('activity.show',compact('activites'));
    }


}
