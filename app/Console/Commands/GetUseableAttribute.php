<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Tt\Sqarray;

class GetUseableAttribute extends Command
{
    use Sqarray;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:useableattribute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach ([  'table1','table2','table3','zb_array','sq_array'] as $value) {
            $this->getKeys($value);
        }
        

        foreach ([$this->table1,$this->table2,$this->table3] as 
                 $key => $table) {
            $key++;
            foreach ($table as $value) {

                if (in_array($value, $this->zb_array)) {
                    $this->info("第{$key}表的{$value}字段在zb中。");
                } else {

                    $this->error("第{$key}表的{$value}字段不在zb中啊。");
                }


                if (in_array($value, $this->sq_array)) {
                    $this->info("第{$key}表的{$value}字段在sq中。");
                } else {

                    $this->error("第{$key}表的{$value}字段不在sq中啊。");
                }
                $this->info('-----------------------'); 
            }
            $this->info('======================='); 
        }      
    }

    public function getKeys($array)
    {
        $this->$array = array_keys($this->$array);
        foreach ($this->$array as $key => $value) {
            $this->$array[$key] = strtoupper($value);            
        }
    }

    private $zb_array = [                                          
          "GSDM" => 1,
          "KJND" => 1,
          "MXZBLB" => 1,
          "MXZBBH" => 1,
          "MXZBWH" => 1,
          "MXZBXH" => 1,
          "ZZBLB" => 1,
          "ZZBBH" => 1,
          "FWRQ" => 1,
          "DZKDM" => 1,
          "YSDWDM" => 1,
          "ZBLYDM" => 1,
          "YSKMDM" => 1,
          "ZJXZDM" => 1,
          "JFLXDM" => 1,
          "ZCLXDM" => 1,
          "XMDM" => 1,
          "ZFFSDM" => 1,
          "JE" => 1,
          "ZY" => 1,
          "LRR_ID" => 1,
          "LRR" => 1,
          "LR_RQ" => 1,
          "XGR_ID" => 1,
          "CSR_ID" => 1,
          "CSR" => 1,
          "CS_RQ" => 1,
          "HQBZ" => 1,
          "HQWCBZ" => 1,
          "SHJBR_ID" => 1,
          "SHR_ID" => 1,
          "SHR" => 1,
          "SH_RQ" => 1,
          "SNJZ" => 1,
          "NCYS" => 1,
          "BNZA" => 1,
          "BNZF" => 1,
          "BNBF" => 1,
          "ZBYE" => 1,
          "SJLY" => 1,
          "YZBLB" => 1,
          "YSGLLXDM" => 1,
          "ZBZT" => 1,
          "TZBZ" => 1,
          "JZRQ" => 1,
          "ZBID" => 1,
          "ZBIDWM" => 1,
          "DCBZ" => 1,
          "DCRID" => 1,
          "STAMP" => 1,
          "OAZT" => 1,
          "TZH" => 1,
          "JZR_ID" => 1,
          "PZFLH" => 1,
          "JZR_ID1" => 1,
          "PZFLH1" => 1,
          "DJZT" => 1,
          "SCJHJE" => 1,
          "DYBZ" => 1,
          "YWLXDM" => 1,
          "XMFLDM" => 1,
          "SJWH" => 1,
          "KZZLDM1" => 1,
          "KZZLDM2" => 1,
          "ASHR_ID" => 1,
          "ASHR" => 1,
          "ASH_RQ" => 1,
          "ASHJD" => 1,
          "AXSHJD" => 1,
          "ASFTH" => 1,
          "ZBLB" => 1,
          "DZKMC" => 1,
          "ZBLYMC" => 1,
          "YSDWMC" => 1,
          "YSDWQC" => 1,
          "YSKMMC" => 1,
          "YSKMQC" => 1,                                         
          "ZJXZMC" => 1,
          "XMMC" => 1,
          "YSGLLXMC" => 1,
          "HQNAME" => 1,
          "ZZBWH" => 1,
          "ZZBXH" => 1,
          "YWLXMC" => 1,
          "XMFLMC" => 1,
          "KZZLMC1" => 1,
          "KZZLMC2" => 1,
          "ZFFSLB" => 1,
          "DYBZ1" => 1,
        ];

    private $sq_array = [
          "DZKDM" => "23",
          "DZKMC" => "乡财股",
          "YSDWDM" => "901006001",
          "YSDWMC" => "枚江镇行政",
          "ZJXZDM" => "9",
          "ZJXZMC" => "其他资金",
          "ZFFSDM" => "02",
          "YSKMDM" => "2299901",
          "YSKMMC" => "其他支出",
          "JFLXDM" => "30299",
          "JFLXMC" => "其他商品和服务支出",
          "ZCLXDM" => "0202",
          "ZCLXMC" => "授权支付",
          "XMDM" => "9",
          "XMMC" => "其他资金",
          "ZBLYDM" => "7",
          "ZBLYMC" => "其他指标",
          "ZJLYMC" => "0",
          "YKJHZB" => "40000",
          "YYJHJE" => "40000",
          "KYJHJE" => "0",
          "YSGLLXDM" => "2",
          "YSGLLXMC" => "乡镇支出",
          "NEWYSKMDM" => "2299901",
          "ZBID" => "001.riqi.0.6175",
          "ZY" => "水利局拨邵溪村2016年县级小农水项目经费",
          "ZBWH" => "公共文号",
  ];
}
