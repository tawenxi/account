<?php

namespace App\Console\Commands;

use App\Acc\Acc;
use App\Model\Payout;
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
    public function __construct(Guzzle $guzz, Excel $guzzleexcel)
    {
        parent::__construct();

        $this->guzz = $guzz;
        $this->guzzleexcel = $guzzleexcel->setExcelFile('excel');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$this->info('现在的session是'.session('ND'));
        //$this->call('pull:shujuyuan');
        //$this->call('test:compare');

        $this->excelData = $this->getExcelData();

        $this->excelData = $this->validate_arr($this->excelData);

        Test::log('验证科目数量');

        $successi = 0;
        $total = 0;
        foreach ($this->excelData as $key => $value) {
            if ($value['amount'] > 0) {
                $value['amount'] = div($value['amount']);
            } else {
                throw new Exception('金额无效');
            }

            if ($value['label'] > 0 && is_numeric($value['label'])) {
                $value['label'] = (integer)($value['label']);
            } elseif ($value['label'] == '@') {

            } else {
                throw new Exception('标签无效');
            }

            $labels =  Payout::all()->pluck('label')->unique();

            if ($labels->contains($value['label']) && $value['label'] != '@') {
                dump($value['label']);
                throw new Exception('重复拨款');
            } 
            // $guzz = \App::make(Guzzle::class, [
            // 'Getsqzb'=> app()->make(Getsqzb::class),
            // 'http'   => app()->make(Http::class),
            // 'payee'  => $value, ]); //传入一个一位数组（账户信息）
            $paid_amount = 0;
            $pm = $value['amount'];
            $value['zbid'] = str_replace(' ', '', $value['zbid']);
            $money_id = stristr($value['zbid'], '+')?explode('+', $value['zbid']):[$value['zbid']];

            while ($paid_amount < $pm) {
                
                $value['zbid'] = array_shift($money_id);


                if (!isset($value['zbid'])) throw new Exception('没有设置足够的zbid');

                if (strlen($value['zbid'])!=14 AND strlen($value['zbid'])!=15 AND strlen($value['zbid'])!=16) throw new Exception('zbid长度错误');
                if (preg_match("/001\.201\d\.0\.\d{3,5}/", $value['zbid']) != 1) 
                    throw new Exception('zbid格式不正确');
                $KYJHJE = $this->guzz->get_zbdata($value['zbid'])['KYJHJE'];     
                if ($KYJHJE == 0)  continue;
                $value['amount'] = ($KYJHJE>($pm-$paid_amount))?
                ($pm-$paid_amount):($KYJHJE);

                $value['amount'] = div($value['amount']);

                $this->instantGuzz($value);
                $this->guzz->add_post();                  // 拨款开关

                $res = $this->guzz->savesql($value);

                $this->line($value['zbid'].'---可用金额：'.$KYJHJE.'---使用了'.$value['amount']);
                $paid_amount += $value['amount'];
                $total = $total + $value['amount'];
                
            }

            $successi++;
            
            $this->info('success--第'.$successi.'条数据拨款成功'.$value['zhaiyao'].'--'.$pm);
        }
        Test::log('注入授权数据');
        $this->info('success--'.$successi.'条数据拨款成功');
        $this->info('success--拨款总金额为'.div($total));


        $this->guzz->updatedb()->pluck('KYJHJE')->each(function ($val) {
            ($val >= 0) ? '' : $this->error('出大错了，出现可用金额负数'.$val);
        });

        $this->info('================数据更新=============');
        $this->call('pull:data');
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
            $arr[$key]['amount'] = div((float)$arr[$key]['amount']);
            $arr[$key]['kemu'] = $arr[$key]['kemuname'] = '@';   //为了不经常忘记加@所以这里就强制@
                
            $Validator = \Validator::make($arr[$key], [
                'payeeaccount'=> 'numeric',
                'amount'      => 'numeric|between:0.01,3000000',
                //'zbid'        => 'size:15',
                ],
                [
                'numeric'     => ':attribute 必须为纯数字',
                'size'        => ':attribute 必须为15位',
                ],
                [//'zbid'       => 'ZBID',
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

        

            if (count($value) != 10) {
                throw new Exception('warning:输入字段数量不为10'.__line__);
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
