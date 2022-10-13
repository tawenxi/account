<?php

namespace App\Acc;

class Llj
{
    public function show()
    {
        echo 'I am Llj function';
    }

    public function getknite(\Closure $knite)
    {
    	if (is_callable($knite)) {
    		$knite('我被打印出来了');
    		return $this;
    	}
    }
}
