<?php

namespace App\Services;

class Account
{
	public function getAccount()
	{
		$topics = \App\Model\Account::select(['id', 'name as label'])
                ->where('id', '>','0')->get();

    	return $topics;
	}
}
