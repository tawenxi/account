<?php
namespace App\PresenterForBlade;

 

class ZbPresenter
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

    public function amount()
    {
    	return div($this->model->JE);
    }

    public function getRowClass()
    {
        return ($this->model->projects
                    ->sum(function($item){
                         return $item->pivot->amount;
                            })>0
                )?'alert-warning':
                (abs($this->model->JE-$this->model->zfpzs->sum('JE'))<1?'alert-danger':"");
    }

    public function beizhu()
    {
        return $this->model->beizhu?$this->model->beizhu:'';
    }

    public function devidedCount()
    {
        return $this->model->projects
                      ->sum(function($item){
                            return $item->pivot->amount;
                        });
    }

    public function costCount()
    {
        return $this->model->zfpzs->count();
    }

    public function shouquan()
    {
        return $this->model->shouquan->sum('YKJHZB');
    }

    public function zhijie()
    {
        return $this->model->zhijie->sum('YKJHZB');
    }

    public function YSDW()
    {
        return substr($this->model->YSDWMC, 9);
    }

    public function presenter()
    {
        return $this->model->presenter();
    }
}
