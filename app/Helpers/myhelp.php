<?php

if (!function_exists('Myhelp')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function Myhelp(\Cache $cache)
    {
    	dd($cache);
    }
}


if (!function_exists('div')) {

    /**
     * return bcdiv
     *
     * @param $amount
     * @return 
     */
    function div($amount)
    {
        return bcdiv(round($amount,2), '1', 2);
    }
}

