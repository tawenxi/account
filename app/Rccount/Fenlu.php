<?php

namespace App\Rccount;

use Illuminate\Database\Eloquent\Model;
use App\Rccount\Bill;
use App\Rccount\Robot; 

class Fenlu extends \LaravelArdent\Ardent\Ardent
{
    public static $rules = [
    'kjqj' => "required|regex:/^\d{6}$/|between:6,6",
//    'pzh'=>['required','regex:/^政府    [\d| ]\d$/','between:8,8'],
    'pzh'=>'required|numeric|between:1,200',
    'flh'=>"required|regex:/\d+$/",
    'zy'=>"required",
    'kmdm'=>"required|regex:/^\d+$/",
    'jdbz'=>['required','regex:/[借|贷]$/'],
    'je'=>"required|numeric",
    'wldrq' => "required|regex:/\d{8}$/|between:8,8",
    ];


    public static $customMessages = array(
    'required' => 'The :attribute field is required.',
    'regex'=> ' :attribute 正则错误',
  );


    public function beforeSave() {//先用rules检核 再beforesave
        //dd('before');
        $robot = new Robot();
        if(is_numeric($this->pzh) && $this->pzh<10) {
          $this->pzh = '政府     '.$this->pzh;
        } elseif (is_numeric($this->pzh) && $this->pzh>=10){
          $this->pzh = '政府    '.$this->pzh;
        } else {
            return false;
        }


        if ($this->flh == '1') {
            //echo 'flh';
           $check = $robot->check_last_balance($this->list_id);
           if (!$check) {
            dd('借贷平衡失败');
           }
        }


        if (substr($this->kmdm, 0,1) == 4 OR 
            substr($this->kmdm, 0,1) == 5) {
            if ($this->xmdm != '1001') {
                    dd('xmdm错误');
                }
        } else {
            if ($this->xmdm != '') {
                    dd('xmdm错误');
          }

        }
    
  }

    public function afterSave() {
        echo '.';
    
  }







    public $timestamps = false;

    public function list()
    {
    	return $this->belongsTo(Bill::class,'id','list_id');
    }
    public function setXmdmAttribute($val)
    {
        $this->attributes['xmdm'] = $val?$val:"";
    }
    protected $fillable = [
    'gsdm',
    'kjqj',
    'pzly',
    'pzh',
    'flh',
    'zy',
    'kmdm',
    'wbdm',
    'hl',
    'jdbz',
    'wbje',
    'je',
    'spz',
    'wldrq',
    'sl',
    'dj',
    'bmdm',
    'wldm',
    'xmdm',
    'fzsm1',
    'fzsm2',
    'fzsm3',
    'fzsm4',
    'fzsm5',
    'fzsm6',
    'fzsm7',
    'fzsm8',
    'fzsm9',
    'cess',
    'fplx',
    'fprq',
    'fphfw1',
    'fphfw2',
    'jsfs',
    'zydm',
    'fzdm4',
    'fzdm5',
    'fzdm6',
    'fzdm7',
    'fzdm8',
    'fzdm9',
    'fzdm10',
    'list_id',];
}
