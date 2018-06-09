<?php
namespace App\PresenterForBlade;

 

class ZbdetailPresenter
{
	public $model;
   
    public function __construct($model)
    {
    	$this->model = $model;
        
    }


    public function __get($property)
    {
    	return $this->model->$property;
    }

    public function accountname()
    {
    	return substr($this->model->account->name,0,1+strrpos($this->model->account->name,'@')).substr($this->model->account->name,1+strrpos($this->model->account->name,'-'));
    }

    public function zbid()
    {
    	return str_replace('.', '-', $this->model->ZBID);
    }

    public function getClass()
    {
    	return ($this->model->SH_RQ)?(($this->model->NEWDYBZ==='已打印')?((substr($this->model->QS_RQ,3)?'btn btn-success btn-sm':'btn btn-success btn-sm')):'btn btn-primary btn-sm'):'btn btn-danger btn-sm';
    }

    public function getCaizhengClass()
    {
    	return ($this->model->SKZH == "1783401262206010010001")?'btn btn-sm btn-danger':'';
    }

    public function YSDW()
    {
    	return substr($this->model->YSDWMC, 9);
    }

    public function villageClass()
    {
    	return ($this->model->village=='其他')?'btn btn-danger btn-sm':'btn btn-success btn-sm';
    }

    public function villageLink()
    {
    	return ($this->model->village=='其他')?'/zbdetail?search=YSDWMC:%E6%89%B6%E8%B4%AB&only=other':"/project/tozfl/{$this->model->village}";
    }

    public function amount()
    {
    	return div($this->model->JE);
    }

    public function presenter()
    {
    	return $this->model->presenter();
    }
}
