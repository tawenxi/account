<?php

namespace App\Model\Tt;

use App\Model\Tt\Data;

trait Sqarray
{
    use Data;
    public $table1 = [//ZB_ZFPZDJBH

                'Gsdm'        =>  "'001'"  ,    //
                'Kjnd'        =>  "'~~~~~会计年度'",    //
                'Pdqj'        =>  "'~~~~~会计期间'",    //
                'Pdh'         =>  "to_char(iPDh+1)",    //
                'zflb'        =>  "'0'",    // 不十分确定
                'Djbh'        =>  "zfpzdjbh",    //
                'xjbz'        =>  "'0'",    // 不十分确定
                'zphm'        =>  "'_'",    // 不十分确定
                'Pdrq'        =>  "'~~~~~会计日期'",    // 
                'Dzkdm'       =>  "'~~~~股室代码~~~~'",    //  可查   股室
                'Ysdwdm'      =>  "'~~~~预算单位代码~~~~'",    // 可查
                'Fkrdm'       =>  "'00030019'",    //
                'Fkr'         =>  "'遂川县财政局左安镇财政所（零余额账户）'",  
                'Fkryhbh'     =>  "'00030019'",    //
                'Fkzh'        =>  "'178347750000004247'",    //
                'Fkrkhyh'     =>  "'农商行左安支行'",    //
                'Fkyhhh'      =>  "'012'",    //
                'PJPCHM'      =>  "'_'",    //   不十分确定
                'Skrdm'       =>  "''",    //
                'Skr'         =>  "'叶涛'",    //
                'Skryhbh'     =>  "''",    //
                'Skzh'        =>  "'178190121002547948'",    //
                'Skrkhyh'     =>  "'遂川县农商合作银行'",    //
                'Skyhhh'      =>  "'_'",    //
                'Zy'          =>  "'zhaiyao'",    //
                'FJS'         =>  "0",    //
                'lrr_ID'      =>  "913",    //
                'lrr'         =>  "'康金云'",    //
                'lr_rq'       =>  "to_char(sysdate,'yyyymmdd')",    //
                'dwshr_id'    =>  "-1",    //
                'dwshr'       =>  "''",    //
                'dwsh_rq'     =>  "''",    //
                'cxbz'        =>  "'0'",    // 查询标志
                'bz2'         =>  "'0'",    //  标志
                'zt'          =>  "'0'",    //状态
                'dybz'        =>  "'0'",    //  打印标志
                'ZZPZ'        =>  "'0'",    //  纸质
        ];


    public $table2 = [//ZB_ZFPZNR_Y
 
                'Gsdm'        =>  "'001'",    //
                'Kjnd'        =>  "'~~~~~会计年度'",    //
                'JHID'        =>  "''",    //    不十分确定
                'ZBID'        =>  "'~~~~指标ID~~~~'",    //   变量变量
                'Pdqj'        =>  "'~~~~~会计期间'",    //
                'Pdh'         =>  "to_char(iPDh+1)",    //
                'pdxh'        =>  "1",    //  不明确含义
                'zflb'        =>  "'0'",    //  不十分确定
                'LINKID'      =>  "-1",    //   不明确含义 
                'zjxzdm'      =>  "'~~~~资金性质代码~~~~'",    //  可查
                'jsfsdm'      =>  "'2'",    //   结算方式代码  中文名：转账
                'Yskmdm'      =>  "'~~~~预算科目代码~~~~'",    //    可查
                'Jflxdm'      =>  "'~~~~经济分类代码~~~~'",    //   可查
                'zffsdm'      =>  "'02'",    //
                'zclxdm'      =>  "'0202'",    //
                'ysgllxdm'    =>  "'~~~~YSGLLXDM~~~~'",    //  可查
                'zblydm'      =>  "'~~~~zblydm~~~~'",    //    可查指标来源
                'xmdm'        =>  "'~~~~项目代码~~~~'",    //      可查
                'SJWH'        =>  "'_'",    //        可查上级文号
                'BJWH'        =>  "'_'",    //       不十分确定 本级文号
                'YWLXDM'      =>  "'~~~~_~~~~(findinzb)'",    // 查询zbs确定全是'_'  
                'XMFLDM'      =>  "'~~~~_~~~~(findinzb)'",    //查询zbs 确定全是'_'
                'KZZLDM1'     =>  "'_'",    //         查询zbs 确定全是'_'
                'KZZLDM2'     =>  "'_'",    //     查询zbs 确定全是'_'
                'zbje'        =>  "4000",    //
                'yyzbje'      =>  "1",    //
                'kyzbje'      =>  "3999",    //
                'JE'          =>  "1",    //
            ];

    public $table3 = [//ZB_ZFPZNR_Y_MC
                'GSDM'         =>  "'001'",
                'KJND'         =>  "'~~~~~会计年度'",
                'ZFLB'         =>  "'0'",
                'PDH'          =>  "to_char(iPDh+1)",
                'PDQJ'         =>  "'~~~~~会计期间'",
                'JSFSMC'       =>  "'转账'",
                'NEWDYBZ'      =>  "'未打印'",
                'NEWZZPZ'      =>  "'纸质'",
                'NEWCXBZ'      =>  "'正常凭证'",
                'NEWPZLY'      =>  "'正常'",
                'NEWZT'        =>  "'正常'",
                'PDXH'         =>  "1",
                'DZKMC'        =>  "'~~~~股室名称~~~~'",  //  可查
                'XMMC'         =>  "'~~~~项目名称~~~~'",   //  可查
                'XMFLMC'       =>  "''",   
                'YSDWMC'       =>  "'~~~~枚江镇行政~~~~'", 
                'YSDWQC'       =>  "'~~~~枚江镇行政~~~~'",
                'YWLXMC'       =>  "''",
                'ZFFSMC'       =>  "'授权支付'",
                'MXZBWH'       =>  "'~~~~公共文号~~~~(findinzb)'",       //  可查  公共文号
                'MXZBXH'       =>  "~~~~MXZBXH~~~~(findinzb)",             //    可查zhibiao  1657
                'ZBLYMC'       =>  "'~~~~其他指标~~~~'",       //  可查
                'ZJXZMC'       =>  "'~~~~其他资金~~~~'",       //  可查
                'YSKMMC'       =>  "'~~~~其他支出~~~~'",       //  可查
                'YSKMQC'       =>  "'~~~~其他支出-其他支出-其他支出~~~~(findinzb)'",  //可查zhibiao        
                'JFLXMC'       =>  "'~~~~其他商品和服务支出~~~~'",  //  可查
                'JFLXQC'       =>  "'~~~~商品和服务支出-其他商品和服务支出~~~~'",   
                //[  '30299'   =>'商品和服务支出-其他商品和服务支出',
                //      '39999'   =>'其他支出-其他支出']
                'ZCLXMC'       =>  "'授权支付'",   
                'YSGLLXMC'       =>  "'~~~~乡镇支出~~~~'",         //  可查
                'KZZLMC1'       =>  "''",
                'KZZLMC2'       =>  "''",

    ];    

}