<?php

namespace App\Console\Commands;

use App\Acc\Acc;
use App\Model\Respostory\Excel;
use App\Model\Respostory\Getsqzb;
use App\Model\Respostory\Guzzle;
use App\Model\Respostory\Http;
use App\Model\Test;
use Illuminate\Console\Command;
use Exception;

class InsertSq extends Command
{
    protected $excelData;

    private $guzzleexcel;
    protected $guzz;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:sq';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '注入授权指标';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Guzzle $guzz)
    {
        parent::__construct();

        $this->guzz = $guzz;
        $this->guzzleexcel = \App::make(Excel::class, ['excelFile'=>'excel']);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->excelData = $this->getExcelData();

        $this->excelData = $this->validate_arr($this->excelData);


        Test::log('验证科目数量');

        $successi = 0;
        foreach ($this->excelData as $key => $value) {
            if ($value['amount'] > 0) {
                $value['amount'] = div($value['amount']);
            } else {
                throw new Exception('金额无效');
            }

            // $guzz = \App::make(Guzzle::class, [
            // 'Getsqzb'=> app()->make(Getsqzb::class),
            // 'http'   => app()->make(Http::class),
            // 'payee'  => $value, ]); //传入一个一位数组（账户信息）
            $this->instantGuzz($value);
            if (stristr($this->excelData[$key]['kemu'], '#')) {
                $this->info('info:第'.(1 + $successi).'条数据做账成功但未授权支付'.$value['zhaiyao']);
            } else {
                //dd($value);
                // dd("拨款成功");//开关
                $this->guzz->add_post();
            }

            
            if (stristr($this->excelData[$key]['kemu'], '***')) {
                $this->info('Info:第'.(1 + $successi).'条数据完成重录，没做账保存'.$value['zhaiyao']);
            } else {
                $res = $this->guzz->savesql($this->excelData[$key]);
            }
            $successi++;
            $this->info('success--第'.$successi.'条数据拨款成功'.$value['zhaiyao'].'--'.$value['amount']);
        }
        Test::log('注入授权数据');
        $this->info('success--'.$successi.'条数据拨款成功');

        $this->guzz->updatedb()->pluck('KYJHJE')->each(function ($val) {
            ($val >= 0) ? '' : $this->error('出大错了，出现可用金额负数'.$val);
        });
        //dump(Test::$info);
    }


    /**
     *
     * validate the arr，sometimes this will not be adhereed
     * @param $arr
     * @return $arr
     */

    protected function validate_arr ($arr)
    {
        foreach ($arr as $key => $value)
        {
            $arr[$key]['payeeaccount'] = trim($arr[$key]['payeeaccount']);
            $arr[$key]['amount'] = trim($arr[$key]['amount']);
            $arr[$key]['zbid'] = trim($arr[$key]['zbid']);
            $arr[$key]['amount'] = div($arr[$key]['amount']);
            $arr[$key]['kemu'] = $arr[$key]['kemuname'] = '@';   //为了不经常忘记加@所以这里就强制@
                
            $Validator = \Validator::make($arr[$key], [
                'payeeaccount'=> 'numeric',
                'amount'      => 'numeric|between:0.01,3000000',
                'zbid'        => 'size:15',
                ],
                [
                'numeric'     => ':attribute 必须为纯数字',
                'size'        => ':attribute 必须为15位',
                ],
                ['zbid'       => 'ZBID',
                'payeebanker' => 'Banker Number',
            ]);
            Test::log('验证excel数据');
            if ($Validator->fails()) {
                Test::log('!!!检核数据错误，Excel.xls有错误');
                foreach ($Validator->errors()->all() as $error) {
                    $this->info($error);
                }
                throw new Exception('检核数据出错'.__line__);
            }

        

            if (count($value) != 8) {
                throw new Exception('warning:输入字段数量不为8'.__line__);
            }

            if (count($arr[$key]['kemuname']) == 1 && is_array($arr[$key]['kemuname'])) {
                $arr[$key]['kemuname'] = (string) (reset($arr[$key]['kemuname']));
                
                
            }
            //这里使用了reset函数
            if (is_array($arr[$key]['kemuname'])) {
                throw new Exception('请选择确认会计科目并包含@，或者修改关键字');
            }
            
        }
        return $arr;
    }


    /**
     *
     * get Excel data
     *
     */

    protected function getExcelData()
    {
        $searchobject = \App::make('acc'); //初始化
        $data = $this->guzzleexcel
                    ->setSkipNum()
                    ->getexcel()
                    ->each(
                        function ($item) use ($searchobject) {
                            $item['kemuname'] = stristr($item['kemu'], '@') ?
                    $item['kemu'] :
                    $searchobject->findac($item['kemu']);
                        }
            )->toArray();
        Test::log('获取excel数据并增加科目');
        return $data;
    }

    /**
     *
     * 把guzzle变成为注入工具
     * @param 接收一个数据数组
     *
     */
    
    protected function instantGuzz($data)
    {
        $this->guzz->setPayee($data)->setBody();
    }
    
}
