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


    function filterVillage($ZY) 
    {
        $villages = ['东光','石窝','樟木','洋溪','安全','望月','鹤坑','桃源'];
        foreach ($villages as $village) {
            if (strstr($ZY, $village)) 
                return $village;
        }
        return false;
   }

   /* 根据摘要返回所有的村别数组 */
   
    function filterVillage_all($ZY) 
    {
        $villages = ['东光','石窝','樟木','洋溪','安全','望月','鹤坑','桃源'];
        $filter_village = [];
        foreach ($villages as $village) {
            if (strstr($ZY, $village)) 
                $filter_village[] = $village;
        }
        //return implode($filter_village, '-');
        return $filter_village;
   } 

   function boss_village($boss,$poor = null)
   {
        $query = \App\Model\Zfpz::withoutGlobalScopes()->where('SKR',$boss);
        $query = $poor?$query->where('YSDWDM','901012013'):$query;

        $ZY = $query->get()->pluck('ZY')->unique()->toArray();
        $ZY = implode($ZY, '');
       return filterVillage_all($ZY);
   }


   function findOriginZb($zbid)
   {

        $zbid =\App\Model\Zb::WithoutGlobalScopes()->where('ZBID',$zbid)->first();

      if ( $zbid->prezbid() === false) {
          return  $zbid;
      }
      while ($zbid = $zbid->prezbid()) {
          $originZb = $zbid;
      }
      if ($originZb) {
          return $originZb;
      }
        return null;
   }


