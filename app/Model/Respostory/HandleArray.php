<?php

namespace App\Model\Respostory;

use Exception;
use App\Model\Guzzledb;
use App\Model\Tt\Sqarray;

class HandleArray
{
    use sqarray;
    public $guzzledb;

    public function __construct(Guzzledb $guzzledb)
    {
        $this->guzzledb = $guzzledb;
    }

    public function updateSqarray()
    {
        $this->table1['Dzkdm'] = "'{$this->_validataChanging($this->guzzledb->DZKDM)}'";
        $this->table1['Ysdwdm'] = "'{$this->_validataChanging($this->guzzledb->YSDWDM)}'";

        $this->table2['ZBID'] = "'{$this->_validataChanging($this->guzzledb->ZBID)}'";
        $this->table2['zjxzdm'] = "'{$this->_validataChanging($this->guzzledb->ZJXZDM)}'";
        $this->table2['Yskmdm'] = "'{$this->_validataChanging($this->guzzledb->YSKMDM)}'";
        $this->table2['Jflxdm'] = "'{$this->_validataChanging($this->guzzledb->JFLXDM)}'";
        $this->table2['ysgllxdm'] = "'{$this->_validataChanging($this->guzzledb->YSGLLXDM)}'";
        $this->table2['zblydm'] = "'{$this->_validataChanging($this->guzzledb->ZBLYDM)}'";
        $this->table2['xmdm'] = "'{$this->_validataChanging($this->guzzledb->XMDM)}'";
        $this->table2['YWLXDM'] = "'{$this->_validataChanging($this->_findInZb('YWLXDM'))}'";
        $this->table2['XMFLDM'] = "'{$this->_validataChanging($this->_findInZb('XMFLDM'))}'";



        $this->table3['YSDWMC'] = "'{$this->_validataChanging($this->guzzledb->YSDWMC)}'";
        $this->table3['YSDWQC'] = "'{$this->_validataChanging($this->guzzledb->YSDWMC)}'";
        $this->table3['DZKMC'] = "'{$this->_validataChanging($this->guzzledb->DZKMC)}'";
        $this->table3['XMMC'] = "'{$this->_validataChanging($this->guzzledb->XMMC)}'";
        $this->table3['MXZBWH'] = "'{$this->_validataChanging($this->_findInZb('MXZBWH'))}'";
        $this->table3['MXZBXH'] = "{$this->_validataChanging($this->_findInZb('MXZBXH'))}";
        $this->table3['ZBLYMC'] = "'{$this->_validataChanging($this->guzzledb->ZBLYMC)}'";
        $this->table3['ZJXZMC'] = "'{$this->_validataChanging($this->guzzledb->ZJXZMC)}'";//更改了从sq表获得数据
        $this->table3['YSKMMC'] = "'{$this->_validataChanging($this->guzzledb->YSKMMC)}'";
        $this->table3['YSKMQC'] = "'{$this->_validataChanging($this->_findInZb('YSKMQC'))}'";
        $this->table3['JFLXMC'] = "'{$this->_validataChanging($this->guzzledb->JFLXMC)}'";

        
        $this->table3['JFLXQC'] = "'{$this->_validataChanging($this->_findInZb('JFLXQC'))}'";
        $this->table3['YSGLLXMC'] = "'{$this->_validataChanging($this->guzzledb->YSGLLXMC)}'";

        $this->updateDate();

        return [$this->table1, $this->table2, $this->table3];
    }


    private function updateDate ()
    {
        $this->table1['Kjnd'] = "'".config('app.MYND')."'";
        $this->table1['Pdqj'] = "'".config('app.MYND')."01'";
        $this->table1['Pdrq'] = "'".config('app.MYND')."0101'";

        $this->table2['Kjnd'] = "'".config('app.MYND')."'";
        $this->table2['Pdqj'] = "'".config('app.MYND')."01'";

        $this->table3['KJND'] = "'".config('app.MYND')."'";
        $this->table3['PDQJ'] = "'".config('app.MYND')."01'";
    }


    private function _findInZb ($attribute)
    {
        return \DB::table('zbs')->where('ZBID', $this->guzzledb->ZBID)->value($attribute);
    }


    private function _validataChanging($data)
    {
        if ($data === NULL) {
            throw new Exception('NULL出现了.HandleArray.php:96'.$data);
        }
        return $data;
    }
}
