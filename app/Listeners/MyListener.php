<?php

namespace App\Listeners;

/**
 * MyListener
 */
class MyListener
{
    public function whenMyEvent($val)
    {
    	dump($val);
    }
}