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
        return number_format($amount, 2, '.', '');
    }
}

if (!function_exists('preg_replace_with_count')) {

    /**
     * return preg_replace_with_count
     *
     * @param $amount
     * @return 
     */
    function preg_replace_with_count($pattern, $replacement, $subject, $count)
    {

        $result = preg_replace($pattern, $replacement, $subject, -1, $fcount);

        if ($count === $fcount) {
            return $result;
        } else {
            dd($count, $fcount);
            throw new Exception('替换次数错误');
        }
    }
}


    function strReplaceAssoc(array $replace, $subject) { 
       return stro_replace(array_keys($replace), array_values($replace), $subject);    
    } 

    function stro_replace($search, $replace, $subject)
    {
        return strtr( $subject, array_combine($search, $replace) );
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

    function encode($data) //传入的是中文明码
    {
        return urlencode(iconv('UTF-8','GB2312', $data));
    }

    function decode($data) //传入的是最原始的data 暗码
    {
        return iconv('GB2312', 'UTF-8', urldecode($data));
    }


    function flash($title = null, $message = null)
    {
        $flash = app('App\Http\Flash');

        if (func_num_args() == 0) {
            return $flash;
        }

        return $flash->info($title, $message);
    }

     


