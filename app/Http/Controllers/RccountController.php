<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Respostory\Excel;
use App\Rccount\Bill;
use App\Rccount\Fenlu;
use DB;


class RccountController extends Controller
{
	    public function __construct(Excel $excel){
        //$this->excel = $excel;
        $this->guzzleexcel = \App::make(Excel::class,['excelFile'=>'fenlus']);
    }
    public $list = '~month~~政府    id~date~0~9~刘小勇~-1~~~-1~~date~~~0~0~1~abstract~amount~~~遂川财政局~';
    //month 201706
    //id 空1
    //date 20170601
    //abstract 摘要
    //amount 金额

    public $content = '~month~~政府    id~row~abstract~kemu~~1~JD~0~amount~~date~0~0~~001~xmdm~~~~~~~~~~0~~~0~0~~~~~~~~~';

    //month 201705
    //id 空1
    //row 行号
    //abstract 摘要
    //kemu 科目
    //JD 借贷
    //amount
    //date
    //xmdm 项目代码1001 或者空

    public function index(){
    	$bills = $this->guzzleexcel->getExcel();
    	dd($bills);
    	$fenlus = $this->guzzleexcel->getExcel();
    	
    	$fenlus->each(function($v){
    		Fenlu::create($v->toArray());
    	});
    	

    }


    public function rr(){
       // phpinfo();
      // $a = \DB::connection('sqlsrv')->table('GL_Pzml')->first();
       //$a = get_object_vars($a);

       //$a = \DB::connection('sqlsrv')->table('GL_Pzml')->get();


      $arrays = DB::connection('mysql')->table('lists')->get()->toarray();

            $a = collect($arrays)->map(function($item,$key){
                return collect($item)->diffKeys([
                    'id' => 2,
                ])->all();

            })->toArray();

       dd($a);   
    //$a = \DB::connection('imiguo')->table('accounts')->get();


       //   $arrays = \DB::connection('mysql')->table('guzzledbs')->get()->all();
       //      $arrays = array_map('get_object_vars', $arrays);
       //      dd($arrays);
       //      DB::connection('imiguo')->table($table)->insert($arrays);
       //      $this->info('success-'.$table);
       // dd($a);
    }

}
