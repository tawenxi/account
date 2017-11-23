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
        return bcdiv(begoodself($amount), '1', 2);
    }


}





    function mul($amount)
    {
        return round($amount*100,0);
    }

    function beint100($amount)
    {
        return number_format($amount, 2, '.', '')*1000/10;
    }

    function begoodself($amount)
    {
        return number_format($amount, 2, '.', '');
    }

     


