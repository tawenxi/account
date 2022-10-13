<?php

namespace App\Model\Respostory;

use Illuminate\Database\Eloquent\Model;

class Excel extends Model
{
    private $excelFile;
    private $import;
    public $title;
    public $skipNum;
    /**
     *
     * 应用模式 $Excel->setExcelFile('file')->getExcel()
     *
     */
    
    public function setExcelFile($excelFile)
    {
        cache(['excel'=>$excelFile], 10);
        $this->excelFile = $excelFile;
        $this->import = app()->make("\App\Model\SalaryListImport");
        $this->setDate();
        $this->title = $this->getTitle();
        return $this;
    }

    public function getTitle()
    {
        return $this->import->first()->keys()->filter(
            function ($item) {
                return $item != null;
            })->toArray();
    }

    private function setDate()
    {
        $this->import = $this->import->setDateColumns([
        'created_at',
        'updated_at',
        'date', ]);
    }

    public function getExcel()
    {
        $skip = empty($this->skipNum) ? 0 : $this->skipNum;

        return $this->import->skipRows($skip)->takeRows(2000)->get($this->title);
    }

    /**
     * TODO:插入数据库 海没开始用
     * - First todo item
     * - Second todo item.
     */
    public function insertSql()
    {
        $this->getExcel()->map(function ($v) {
            static $i;
            \DB::table($this->excelFile.'s')->insert($v->toArray());
            $i++;
        });
    }

    public function setSkipNum()
    {
        $this->skipNum = $this->import->calculate()->first()->amount;

        return $this;
    }

    /**
     * 以下是导出的时候才用的方法
     * $excel->setViewName('guzzle.preview')->setViewData(compact('collection'))->export();.
     */
    private $viewName;
    private $viewDate;

    public function exportBlade($blade, $data)
    {

        if (\Request::has('export')) {

            $data = $data['results']->map(function($val){
                return $val->presenter()['data'];
            })->toArray();
            return $this->setViewName($blade)->setViewData($data)->export($blade);
            //return rediresct()->back();
        } else {
            return view($blade, $data);
        }
    }

    public function export($blade)
    {
        $data = $this->viewData;
        \Excel::create($blade,function($excel) use ($data,$blade){
            $excel->sheet($blade, function($sheet) use ($data){
                $sheet->rows($data);
            });
        })->export('xls');
    }

    public function setViewName($viewName)
    {
        $this->viewName = $viewName;

        return $this;
    }

    public function setViewData($viewData)
    {
        $this->viewData = $viewData;

        return $this;
    }


    public function export2($cellData)
    {
        \Excel::create('laravel',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->rows($cellData);
            });
        })->export('xls');
    }
}
