<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Model\Respostory\Guzzle;
use App\Model\Respostory\Getsqzb;
use App\Model\Respostory\Excel;
use App\Model\Respostory\Http;

class GuzzleTest extends TestCase
{
    protected $data;
    protected $guzz;


    public function setUp()
    {
        parent::setUp();
        $this->data = [
          "zhaiyao" => "钱塘村2012年新农村建设资金",
          "amount" => 1,
          "payee" => "遂川县枚江镇财政所",
          "payeeaccount" => "178157750000001088",
          "payeebanker" => "遂川县农商合作银行",
          "zbid" => "001.2018.0.8320",
          "kemu" => "@",
          "kemuname" => "@",
        ];
      
        $this->guzz = \App::make(Guzzle::class)->setPayee($this->data);


            ; //传入一个一位数组（账户信息）
    }


    /**
     * A basic test example.
     *
     * @return void
     */

    /** @test */

    public function Amount_must_gt_zero()
    {
        $this->guzz->payee['amount'] = -1;
        $this->expectExceptionMessage('金额不能小于 且必须为数值');
        $this->guzz->add_post(); 
    }  

    public function Amount_must_gt_number()
    {
        $this->guzz->payee['amount'] = 'ds';
        $this->expectExceptionMessage('金额不能小于 且必须为数值');
        $this->guzz->add_post(); 
    }  

    /** @test */
    public function zhaiyao_must_be_changed()
    {
        $this->guzz->payee['zhaiyao'] = 'zhaiyao';
        $this->expectExceptionMessage('摘要必须修改');
        $this->guzz->add_post(); 
    }

    /** @test */
    public function zbid_must_be_begin_with_right_word()
    {
        $this->guzz->payee['zbid'] = '001.2017.1.1234';
        $this->expectExceptionMessage('指标格式不正确');
        $this->guzz->add_post(); 
    }

    /** @test */
    public function zbid_must_be_begin_with_right_lenth()
    {
        $this->guzz->payee['zbid'] = '001.2018.0.123456';
        $this->expectExceptionMessage('指标格式不正确');
        $this->guzz->add_post(); 
    }

    /** @test */
    public function amount_must_be_begin_smaller_than_KYJHJE()
    {
        $this->guzz->payee['amount'] = 100000000000;
        $this->expectExceptionMessage('指标不足');
        $this->guzz->add_post(); 
    }

    /** @test */
    public function account_must_be_number()
    {
        $this->guzz->payee['payeeaccount'] = '10000000-0000';
        $this->expectExceptionMessage('账号非全数值');
        $this->guzz->add_post(); 
    }

    /** @test */
    public function amount_must_be_two()
    {   
        $this->guzz->payee['amount'] = 11.9999;

        $this->expectExceptionMessage('输入了多位小数');
        $this->guzz->add_post(); 
    }





}
