<?php

namespace App\Model\Tt;

trait Sqarray
{
    public $table1 = [//ZB_ZFPZDJBH

                'Gsdm'        =>  "'001'"  ,    //
                'Kjnd'        =>  "'2018'",    //
                'Pdqj'        =>  "'201801'",    //
                'Pdh'         =>  "to_char(iPDh+1)",    //
                'zflb'        =>  "'0'",    // 不十分确定
                'Djbh'        =>  "zfpzdjbh",    //
                'xjbz'        =>  "'0'",    // 不十分确定
                'zphm'        =>  "'_'",    // 不十分确定
                'Pdrq'        =>  "'20180116'",    // 
                'Dzkdm'       =>  "'~~~~股室代码~~~~'",    //  可查   股室
                'Ysdwdm'      =>  "'~~~~预算单位代码~~~~'",    // 可查
                'Fkrdm'       =>  "'00030005'",    //
                'Fkr'         =>  "'遂川县枚江镇财政所（零余额账户）'",  
                'Fkryhbh'     =>  "'00030005'",    //
                'Fkzh'        =>  "'178157750000004662'",    //
                'Fkrkhyh'     =>  "'农商行枚江分理处'",    //
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
                'lrr_ID'      =>  "899",    //
                'lrr'         =>  "'傅爱琼'",    //
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
                'Kjnd'        =>  "'2018'",    //
                'JHID'        =>  "''",    //    不十分确定
                'ZBID'        =>  "'~~~~指标ID~~~~'",    //   变量变量
                'Pdqj'        =>  "'201801'",    //
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
                'KJND'         =>  "'2018'",
                'ZFLB'         =>  "'0'",
                'PDH'          =>  "to_char(iPDh+1)",
                'PDQJ'         =>  "'201801'",
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


    public $sqmoban =<<<EOF
<?xml version="1.0" encoding="GB2312"?><R9PACKET version="1"><SESSIONID></SESSIONID><R9FUNCTION><NAME>AS_DataRequest</NAME><PARAMS><PARAM><NAME>ProviderName</NAME><DATA format="text">DataSetProviderData</DATA></PARAM><PARAM><NAME>Data</NAME><DATA format="text">begin  declare   ierrCount smallint;   szDjBh Varchar(20);   iRowCount smallint ;   iFlen int ;  begin   declare     iPDh int ;     szRBH  char(6) ;     TempExp Exception ;   begin  delete from zb_zfpzdjbh;  select nvl(Length(''),0) into iFlen from dual;  select nvl(max(Substr(djbh,1,6)),'_') into szDJBH  from ZB_VIEW_ZFPZ_BB  Where      Gsdm='001'  and KJND='2018'  and ZFFSDM='02'  and length(djbh) &gt;= 6;  if  szDJBH='_' then select '000001' into szDJBH from dual ; else    if Length(rtrim(szDJBH)) = nvl(Length(''),0) + 6   then       select Substr(szDJBH,iFlen+1,6) into szRBH from dual ;     select to_char(to_number(szRBH)+1) into szRBH from dual ;      while Length(LTrim(RTrim(szRBH)))&lt;6 Loop          select '0' || LTrim(RTrim(szRBH)) into szRBH from dual ;      end Loop ;   select Rtrim('' || szRBH)  into szDJBH from dual ;  else  select '000001' into szDJBH from dual ; end if ;  end if;  select  max(to_number(pdh)) into iPdh  from ZB_ZFPZML_Y  where gsdm='001'    and kjnd='2018' ;  if iPDh is null then select 0 into iPDh from dual; end if;   insert into ZB_ZFPZDJBH values(szDJBH); insert into ZB_ZFPZML_Y(    Gsdm,Kjnd,Pdqj,Pdh,zflb,Djbh,xjbz,zphm,Pdrq,Dzkdm,Ysdwdm,    Fkrdm,Fkr,Fkryhbh,Fkzh,Fkrkhyh,Fkyhhh,PJPCHM,    Skrdm,Skr,Skryhbh,Skzh,Skrkhyh,Skyhhh,    Zy,FJS,lrr_ID,lrr,lr_rq,dwshr_id,dwshr,dwsh_rq,cxbz,bz2,zt,dybz,ZZPZ) select tawenxi1 from zb_zfpzdjbh ;   insert into ZB_ZFPZNR_Y(    Gsdm,Kjnd,JHID,ZBID,Pdqj,Pdh,pdxh,zflb,LINKID,zjxzdm,jsfsdm,Yskmdm,Jflxdm,zffsdm,zclxdm,ysgllxdm,zblydm,xmdm,SJWH,BJWH,YWLXDM,XMFLDM,KZZLDM1,KZZLDM2,zbje,yyzbje,kyzbje,JE) values ( tawenxi2)  ;  Insert Into ZB_ZFPZNR_Y_MC(GSDM,KJND,ZFLB,PDH,PDQJ,JSFSMC,NEWDYBZ,NEWZZPZ,NEWCXBZ,NEWPZLY,NEWZT,PDXH,DZKMC,XMMC,XMFLMC,YSDWMC,YSDWQC,YWLXMC,ZFFSMC,MXZBWH,MXZBXH,ZBLYMC,ZJXZMC,YSKMMC,YSKMQC,JFLXMC,JFLXQC,ZCLXMC,YSGLLXMC,KZZLMC1,KZZLMC2) Values(tawenxi3);      commit;     select iPDh+1 into ierrCount from dual ;    Exception     when others then       RollBack;       select 0 into ierrCount from dual ;   end ;   Open :pRecCur for     select ierrCount RES,szDJBH DJBH from dual;  end; end; </DATA></PARAM></PARAMS></R9FUNCTION></R9PACKET>
EOF
; 

}