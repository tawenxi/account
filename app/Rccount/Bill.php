<?php

namespace App\Rccount;

class Bill extends \LaravelArdent\Ardent\Ardent
{
    public $timestamps = false;
    public $table = 'lists';
    public $pid = 0;

    public static $rules = [
    'kjqj' => "required|regex:/^\d{6}$/|between:6,6",
    //'pzh'=>['required','regex:/^政府    [\d| ]\d$/','between:8,8'],
    'pzh' => 'required|numeric|between:1,200',
    'pzrq'=> "required|regex:/\d{8}$/|between:8,8",
    'srrq'=> "required|regex:/\d{8}$/|between:8,8",
    'pzzy'=> 'required',
    'pzje'=> 'required|numeric',
];

    public static $customMessages = [
    'required' => 'The :attribute field is required.',
    'regex'    => ' :attribute 正则错误',
  ];

    public function beforeSave()
    {
        $pzh = $this->pluck('pzh');
        $i = $this->pid;
        while ($shift = $pzh->shift()) {
            $check = (substr($shift, 7) == ++$i);
            if (!$check) {
                //return false;
                dd('凭证号顺序不对', $shift, $i);
            }
        }
        //dd('before');
        if (is_numeric($this->pzh) && $this->pzh < 10) {
            $this->pzh = '政府     '.$this->pzh;
        } elseif (is_numeric($this->pzh) && $this->pzh >= 10) {
            $this->pzh = '政府    '.$this->pzh;
        } else {
            return false;
        }
    }

    public function afterSave()
    {
        echo '.';
    }

    public function Fenlus()
    {
        return $this->hasMany(Fenlu::class, 'list_id', 'id');
    }

    protected $fillable = [
    'gsdm',
    'kjqj',
    'pzly',
    'pzh',
    'pzrq',
    'fjzs',
    'srID',
    'sr',
    'shID',
    'sh',
    'jsr',
    'jzrID',
    'jzr',
    'srrq',
    'shrq',
    'jzrq',
    'pzhzkmdy',
    'pzhzbz',
    'zt',
    'pzzy',
    'pzje',
    'CN',
    'BZ',
    'kjzg',
    'idpzh',
];
}
