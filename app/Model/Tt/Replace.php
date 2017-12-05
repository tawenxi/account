<?php

namespace App\Model\Tt;

trait Replace
{
    public function checkreplace($data1, $data2)
    {
        if ($data1 == $data2) {
            throw new \Exception('替换失败'.__LINE__, 1);
        }
    }

    public function timereplace($data,$Y,$M,$D)
    {
        $pattern = "/\'\s*20[123]([0-9]{5})\s*\'/";
        $pattern1 = "/\'\s*20[123]([0-9]{3})\s*\'/";
        $pattern2 = "/\'\s*20[123]([0-9]{1})\s*\'/";
        $data = preg_replace_with_count($pattern, "to_char(sysdate,'yyyymmdd')", $data, $D);
        $data = preg_replace_with_count($pattern1, "to_char(sysdate,'yyyymm')", $data, $M);
        $data = preg_replace_with_count($pattern2, "to_char(sysdate,'yyyy')", $data, $Y);

        return $data;
    }

    public function jiema($data)//传入加密内容 解码
    {
        $data = urldecode($data);

        return $data;
    }
}
