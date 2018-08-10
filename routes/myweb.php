<?php
Route::get('ss', function () {
    \App\Model\Post::create(['title'=>'title1','content'=>'mycontent']);
});

Route::get('tb', function(){

    $qq = \App\Model\Guzzledb::find(30);
    //$me = $qq->getArray(1);
    //dd(encode(\App\Model\Guzzledb::first()->generateMybody()));
    dd($qq->comparebody());
    $qq->generateMybody()->encodeMybody(); //可以放在boot里面
    $you = $qq->getArray(1, (\App\Model\Guzzledb::first()->generateMybody()->mybody));
});


Route::get('ff', function(){
    dd(1);
    dd(\DB::connection('sqlsrv')->table('GL_Pzml')->first());
    $search = array('A'=>'B', 'B'=>'C', 'C'=>'D', 'D'=>'E', 'E'=>'F');

$subject = 'ABCDE';
echo strtr($subject,$search); // output: 'BCDEF'
    //dd('2222'.config('myconfig.kjnd').'sss');
});



Route::get('/test', function(App\Acc\Llj $a){
    //s(1,[1,2]);
    // sss_if(11111111, 'User has a last name', 22);
    // sss(str_wrap('foo', '*'));
    // dd(rand_bool());
    $a->getknite(function($a){
        dump($a);
    })->getknite(function($a){
        dump(str_wrap($a,'#'));
    });

});


Route::get('/5', 'LearnController@index5');
Route::get('/2', 'LearnController@index2');
Route::get('/3', 'LearnController@index3');

Route::get('/bc', function(){
    $a = (random_int(0, 500000)+random_int(0, 1))/random_int(01, 100);
    dump('bcdiv'.bcdiv($a,1,'2'));
    dump('rount'.round($a,2));
    echo div($a);
});


Route::get('/muxing/{user}', function (\App\Model\User $user) {
    dd($user);
});


Route::get('/6323151aa', function () {
    header('Content-type: text/html; charset=utf-8');
    if (\Auth::check() && \Auth::user()->id == 39) {
        $a = file_get_contents(storage_path('/logs/logins.log'));
        dd(str_replace('[', '<br/>[', $a));
    } else {
        return redirect()->to('/geren');
    }
});



Route::get('listener', function() {
    \Event::fire(new App\Events\Event('hello,I am the first method,use the old method!!'));
    \Event::fire('Mysubscribe','hello I am coming');
    event('MyEvent','haha,MyListener is happened');
    dump('I am back');
});

Route::view('welcome','welcome');
Route::get('projects-chart','ProjectController@index_chart');


Route::get('hahaha', function(){
        $zb = \App\Model\Zb::first();
        //dd($zb->toarray());
        dd($zb->projects);
});


Route::get('lllll', function(){
        dd(boss_village('遂川县祥发市政工程有限公司'));
});


Route::view('received','received');
Route::view('select','select');


use Illuminate\Support\Facades\Redis;

use App\Events\UserSignup;

Route::get('bibi', function(){
    event(new UserSignup('tawenxi'));
    return 'done';
});


Route::get('www', function(){
    $a = '%3C%3Fxml+version%3D%221.0%22+encoding%3D%22GB2312%22%3F%3E%3CR9PACKET+version%3D%221%22%3E%3CSESSIONID%3E%3C%2FSESSIONID%3E%3CR9FUNCTION%3E%3CNAME%3EAS_DataRequest%3C%2FNAME%3E%3CPARAMS%3E%3CPARAM%3E%3CNAME%3EProviderName%3C%2FNAME%3E%3CDATA+format%3D%22text%22%3EDataSetProviderData%3C%2FDATA%3E%3C%2FPARAM%3E%3CPARAM%3E%3CNAME%3EData%3C%2FNAME%3E%3CDATA+format%3D%22text%22%3Ebegin++declare+++ierrCount+smallint%3B+++szDjBh+Varchar%2820%29%3B+++iRowCount+smallint+%3B+++iFlen+int+%3B++begin+++declare+++++iPDh+int+%3B+++++szRBH++char%286%29+%3B+++++TempExp+Exception+%3B+++begin++delete+from+zb_zfpzdjbh%3B++select+nvl%28Length%28%27%27%29%2C0%29+into+iFlen+from+dual%3B++select+nvl%28max%28Substr%28djbh%2C1%2C6%29%29%2C%27_%27%29+into+szDJBH++from+ZB_VIEW_ZFPZ_BB++Where++++++Gsdm%3D%27001%27++and+KJND%3D%272018%27++and+ZFFSDM%3D%2702%27++and+length%28djbh%29+%26gt%3B%3D+6%3B++if++szDJBH%3D%27_%27+then+select+%27000001%27+into+szDJBH+from+dual+%3B+else++++if+Length%28rtrim%28szDJBH%29%29+%3D+nvl%28Length%28%27%27%29%2C0%29+%2B+6+++then+++++++select+Substr%28szDJBH%2CiFlen%2B1%2C6%29+into+szRBH+from+dual+%3B+++++select+to_char%28to_number%28szRBH%29%2B1%29+into+szRBH+from+dual+%3B++++++while+Length%28LTrim%28RTrim%28szRBH%29%29%29%26lt%3B6+Loop++++++++++select+%270%27+%7C%7C+LTrim%28RTrim%28szRBH%29%29+into+szRBH+from+dual+%3B++++++end+Loop+%3B+++select+Rtrim%28%27%27+%7C%7C+szRBH%29++into+szDJBH+from+dual+%3B++else++select+%27000001%27+into+szDJBH+from+dual+%3B+end+if+%3B++end+if%3B++select++max%28to_number%28pdh%29%29+into+iPdh++from+ZB_ZFPZML_Y++where+gsdm%3D%27001%27++++and+kjnd%3D%272018%27+%3B++if+iPDh+is+null+then+select+0+into+iPDh+from+dual%3B+end+if%3B+++insert+into+ZB_ZFPZDJBH+values%28szDJBH%29%3B+insert+into+ZB_ZFPZML_Y%28++++Gsdm%2CKjnd%2CPdqj%2CPdh%2Czflb%2CDjbh%2Cxjbz%2Czphm%2CPdrq%2CDzkdm%2CYsdwdm%2C++++Fkrdm%2CFkr%2CFkryhbh%2CFkzh%2CFkrkhyh%2CFkyhhh%2CPJPCHM%2C++++Skrdm%2CSkr%2CSkryhbh%2CSkzh%2CSkrkhyh%2CSkyhhh%2C++++Zy%2CFJS%2Clrr_ID%2Clrr%2Clr_rq%2Cdwshr_id%2Cdwshr%2Cdwsh_rq%2Ccxbz%2Cbz2%2Czt%2Cdybz%2CZZPZ%29+select+%27001%27%2C+%272018%27%2C+%27201801%27%2C++to_char%28iPDh%2B1%29%2C%270%27%2C++zfpzdjbh%2C+%270%27%2C+%27_%27%2C+%2720180101%27%2C+%2723%27%2C+%27901012001%27%2C+%2700030019%27%2C+%27%CB%EC%B4%A8%CF%D8%B2%C6%D5%FE%BE%D6%D7%F3%B0%B2%D5%F2%B2%C6%D5%FE%CB%F9%A3%A8%C1%E3%D3%E0%B6%EE%D5%CB%BB%A7%A3%A9%27%2C+%2700030019%27%2C+%27178347750000004247%27%2C+%27%C5%A9%C9%CC%D0%D0%D7%F3%B0%B2%D6%A7%D0%D0%27%2C+%27012%27%2C+%27_%27%2C%27%27%2C+%27%D2%B6%CC%CE%27%2C+%27%27%2C+%27178190121002547948%27%2C+%27%CB%EC%B4%A8%CF%D8%C5%A9%C9%CC%BA%CF%D7%F7%D2%F8%D0%D0%27%2C+%27_%27%2C+%27zhaiyao%27%2C+0%2C913%2C%27%BF%B5%BD%F0%D4%C6%27%2C+to_char%28sysdate%2C%27yyyymmdd%27%29%2C+-1%2C%27%27%2C%27%27%2C+%270%27+%2C%270%27%2C%270%27%2C%270%27%2C%270%27+from+zb_zfpzdjbh+%3B+++insert+into+ZB_ZFPZNR_Y%28++++Gsdm%2CKjnd%2CJHID%2CZBID%2CPdqj%2CPdh%2Cpdxh%2Czflb%2CLINKID%2Czjxzdm%2Cjsfsdm%2CYskmdm%2CJflxdm%2Czffsdm%2Czclxdm%2Cysgllxdm%2Czblydm%2Cxmdm%2CSJWH%2CBJWH%2CYWLXDM%2CXMFLDM%2CKZZLDM1%2CKZZLDM2%2Czbje%2Cyyzbje%2Ckyzbje%2CJE%29+values+%28+%27001%27%2C+%272018%27%2C+%27%27%2C+%27001.2018.0.9377%27%2C+%27201801%27%2C++to_char%28iPDh%2B1%29%2C+1%2C%270%27%2C-1%2C%279%27%2C++%272%27%2C++%272010301%27%2C++%2750299%27%2C++%2702%27%2C++%270202%27%2C++%272%27%2C++%277%27%2C++%279%27%2C++%27_%27%2C+%27_%27%2C+%27_%27%2C+%27_%27%2C+%27_%27%2C+%27_%27%2C+4000%2C++1%2C++3999%2C++1%29++%3B++Insert+Into+ZB_ZFPZNR_Y_MC%28GSDM%2CKJND%2CZFLB%2CPDH%2CPDQJ%2CJSFSMC%2CNEWDYBZ%2CNEWZZPZ%2CNEWCXBZ%2CNEWPZLY%2CNEWZT%2CPDXH%2CDZKMC%2CXMMC%2CXMFLMC%2CYSDWMC%2CYSDWQC%2CYWLXMC%2CZFFSMC%2CMXZBWH%2CMXZBXH%2CZBLYMC%2CZJXZMC%2CYSKMMC%2CYSKMQC%2CJFLXMC%2CJFLXQC%2CZCLXMC%2CYSGLLXMC%2CKZZLMC1%2CKZZLMC2%29+Values%28%27001%27%2C%272018%27%2C%270%27%2Cto_char%28iPDh%2B1%29%2C%27201801%27%2C%27%D7%AA%D5%CB%27%2C%27%CE%B4%B4%F2%D3%A1%27%2C%27%D6%BD%D6%CA%27%2C%27%D5%FD%B3%A3%C6%BE%D6%A4%27%2C%27%D5%FD%B3%A3%27%2C%27%D5%FD%B3%A3%27%2C1%2C%27%CF%E7%B2%C6%B9%C9%27%2C%27%C6%E4%CB%FB%D7%CA%BD%F0%27%2C%27%27%2C%27%D7%F3%B0%B2%D5%F2%D0%D0%D5%FE%27%2C%27%D7%F3%B0%B2%D5%F2%D0%D0%D5%FE%27%2C%27%27%2C%27%CA%DA%C8%A8%D6%A7%B8%B6%27%2C%27%CF%E7%B2%C6%B9%C9%CE%C4%BA%C5%27%2C1877%2C%27%C6%E4%CB%FB%D6%B8%B1%EA%27%2C%27%C6%E4%CB%FB%D7%CA%BD%F0%27%2C%27%D0%D0%D5%FE%D4%CB%D0%D0%27%2C%27%D2%BB%B0%E3%B9%AB%B9%B2%B7%FE%CE%F1%D6%A7%B3%F6-%D5%FE%B8%AE%B0%EC%B9%AB%CC%FC%A3%A8%CA%D2%A3%A9%BC%B0%CF%E0%B9%D8%BB%FA%B9%B9%CA%C2%CE%F1-%D0%D0%D5%FE%D4%CB%D0%D0%27%2C%27%C6%E4%CB%FB%C9%CC%C6%B7%BA%CD%B7%FE%CE%F1%D6%A7%B3%F6%27%2C%27%BB%FA%B9%D8%C9%CC%C6%B7%BA%CD%B7%FE%CE%F1%D6%A7%B3%F6-%C6%E4%CB%FB%C9%CC%C6%B7%BA%CD%B7%FE%CE%F1%D6%A7%B3%F6%27%2C%27%CA%DA%C8%A8%D6%A7%B8%B6%27%2C%27%CF%E7%D5%F2%D6%A7%B3%F6%27%2C%27%27%2C%27%27%29%3B++++++commit%3B+++++select+iPDh%2B1+into+ierrCount+from+dual+%3B++++Exception+++++when+others+then+++++++RollBack%3B+++++++select+0+into+ierrCount+from+dual+%3B+++end+%3B+++Open+%3ApRecCur+for+++++select+ierrCount+RES%2CszDJBH+DJBH+from+dual%3B++end%3B+end%3B+%3C%2FDATA%3E%3C%2FPARAM%3E%3C%2FPARAMS%3E%3C%2FR9FUNCTION%3E%3C%2FR9PACKET%3E';


    $b = '%3C%3Fxml+version%3D%221.0%22+encoding%3D%22GB2312%22%3F%3E%3CR9PACKET+version%3D%221%22%3E%3CSESSIONID%3E%3C%2FSESSIONID%3E%3CR9FUNCTION%3E%3CNAME%3EAS_DataRequest%3C%2FNAME%3E%3CPARAMS%3E%3CPARAM%3E%3CNAME%3EProviderName%3C%2FNAME%3E%3CDATA+format%3D%22text%22%3EDataSetProviderData%3C%2FDATA%3E%3C%2FPARAM%3E%3CPARAM%3E%3CNAME%3EData%3C%2FNAME%3E%3CDATA+format%3D%22text%22%3Ebegin++declare+++ierrCount+smallint%3B+++szDjBh+Varchar%2820%29%3B+++iRowCount+smallint+%3B+++iFlen+int+%3B++begin+++declare+++++iPDh+int+%3B+++++szRBH++char%286%29+%3B+++++TempExp+Exception+%3B+++begin++delete+from+zb_zfpzdjbh%3B++select+nvl%28Length%28%27%27%29%2C0%29+into+iFlen+from+dual%3B++select+nvl%28max%28Substr%28djbh%2C1%2C6%29%29%2C%27_%27%29+into+szDJBH++from+ZB_VIEW_ZFPZ_BB++Where++++++Gsdm%3D%27001%27++and+KJND%3D%272018%27++and+ZFFSDM%3D%2702%27++and+length%28djbh%29+%26gt%3B%3D+6%3B++if++szDJBH%3D%27_%27+then+select+%27000001%27+into+szDJBH+from+dual+%3B+else++++if+Length%28rtrim%28szDJBH%29%29+%3D+nvl%28Length%28%27%27%29%2C0%29+%2B+6+++then+++++++select+Substr%28szDJBH%2CiFlen%2B1%2C6%29+into+szRBH+from+dual+%3B+++++select+to_char%28to_number%28szRBH%29%2B1%29+into+szRBH+from+dual+%3B++++++while+Length%28LTrim%28RTrim%28szRBH%29%29%29%26lt%3B6+Loop++++++++++select+%270%27+%7C%7C+LTrim%28RTrim%28szRBH%29%29+into+szRBH+from+dual+%3B++++++end+Loop+%3B+++select+Rtrim%28%27%27+%7C%7C+szRBH%29++into+szDJBH+from+dual+%3B++else++select+%27000001%27+into+szDJBH+from+dual+%3B+end+if+%3B++end+if%3B++select++max%28to_number%28pdh%29%29+into+iPdh++from+ZB_ZFPZML_Y++where+gsdm%3D%27001%27++++and+kjnd%3D%272018%27+%3B++if+iPDh+is+null+then+select+0+into+iPDh+from+dual%3B+end+if%3B+++insert+into+ZB_ZFPZDJBH+values%28szDJBH%29%3B+insert+into+ZB_ZFPZML_Y%28++++Gsdm%2CKjnd%2CPdqj%2CPdh%2Czflb%2CDjbh%2Cxjbz%2Czphm%2CPdrq%2CDzkdm%2CYsdwdm%2C++++Fkrdm%2CFkr%2CFkryhbh%2CFkzh%2CFkrkhyh%2CFkyhhh%2CPJPCHM%2C++++Skrdm%2CSkr%2CSkryhbh%2CSkzh%2CSkrkhyh%2CSkyhhh%2C++++Zy%2CFJS%2Clrr_ID%2Clrr%2Clr_rq%2Cdwshr_id%2Cdwshr%2Cdwsh_rq%2Ccxbz%2Cbz2%2Czt%2Cdybz%2CZZPZ%29+select+%27001%27%2C+%272018%27%2C+%27201801%27%2C++to_char%28iPDh%2B1%29%2C%270%27%2C++zfpzdjbh%2C+%270%27%2C+%27_%27%2C+%2720180101%27%2C+%2723%27%2C+%27901012001%27%2C+%2700030019%27%2C+%27%CB%EC%B4%A8%CF%D8%B2%C6%D5%FE%BE%D6%D7%F3%B0%B2%D5%F2%B2%C6%D5%FE%CB%F9%A3%A8%C1%E3%D3%E0%B6%EE%D5%CB%BB%A7%A3%A9%27%2C+%2700030019%27%2C+%27178347750000004247%27%2C+%27%C5%A9%C9%CC%D0%D0%D7%F3%B0%B2%D6%A7%D0%D0%27%2C+%27012%27%2C+%27_%27%2C%27%27%2C+%27%D2%B6%CC%CE%27%2C+%27%27%2C+%27178190121002547948%27%2C+%27%CB%EC%B4%A8%CF%D8%C5%A9%C9%CC%BA%CF%D7%F7%D2%F8%D0%D0%27%2C+%27_%27%2C+%27zhaiyao%27%2C+0%2C913%2C%27%BF%B5%BD%F0%D4%C6%27%2C+to_char%28sysdate%2C%27yyyymmdd%27%29%2C+-1%2C%27%27%2C%27%27%2C+%270%27+%2C%270%27%2C%270%27%2C%270%27%2C%270%27+from+zb_zfpzdjbh+%3B+++insert+into+ZB_ZFPZNR_Y%28++++Gsdm%2CKjnd%2CJHID%2CZBID%2CPdqj%2CPdh%2Cpdxh%2Czflb%2CLINKID%2Czjxzdm%2Cjsfsdm%2CYskmdm%2CJflxdm%2Czffsdm%2Czclxdm%2Cysgllxdm%2Czblydm%2Cxmdm%2CSJWH%2CBJWH%2CYWLXDM%2CXMFLDM%2CKZZLDM1%2CKZZLDM2%2Czbje%2Cyyzbje%2Ckyzbje%2CJE%29+values+%28+%27001%27%2C+%272018%27%2C+%27%27%2C+%27001.2018.0.9377%27%2C+%27201801%27%2C++to_char%28iPDh%2B1%29%2C+1%2C%270%27%2C-1%2C%279%27%2C++%272%27%2C++%272010301%27%2C++%2750299%27%2C++%2702%27%2C++%270202%27%2C++%272%27%2C++%277%27%2C++%279%27%2C++%27_%27%2C+%27_%27%2C+%27_%27%2C+%27_%27%2C+%27_%27%2C+%27_%27%2C+4000%2C++1%2C++3999%2C++1%29++%3B++Insert+Into+ZB_ZFPZNR_Y_MC%28GSDM%2CKJND%2CZFLB%2CPDH%2CPDQJ%2CJSFSMC%2CNEWDYBZ%2CNEWZZPZ%2CNEWCXBZ%2CNEWPZLY%2CNEWZT%2CPDXH%2CDZKMC%2CXMMC%2CXMFLMC%2CYSDWMC%2CYSDWQC%2CYWLXMC%2CZFFSMC%2CMXZBWH%2CMXZBXH%2CZBLYMC%2CZJXZMC%2CYSKMMC%2CYSKMQC%2CJFLXMC%2CJFLXQC%2CZCLXMC%2CYSGLLXMC%2CKZZLMC1%2CKZZLMC2%29+Values%28%27001%27%2C%272018%27%2C%270%27%2Cto_char%28iPDh%2B1%29%2C%27201801%27%2C%27%D7%AA%D5%CB%27%2C%27%CE%B4%B4%F2%D3%A1%27%2C%27%D6%BD%D6%CA%27%2C%27%D5%FD%B3%A3%C6%BE%D6%A4%27%2C%27%D5%FD%B3%A3%27%2C%27%D5%FD%B3%A3%27%2C1%2C%27%CF%E7%B2%C6%B9%C9%27%2C%27%C6%E4%CB%FB%D7%CA%BD%F0%27%2C%27%27%2C%27%D7%F3%B0%B2%D5%F2%D0%D0%D5%FE%27%2C%27%D7%F3%B0%B2%D5%F2%D0%D0%D5%FE%27%2C%27%27%2C%27%CA%DA%C8%A8%D6%A7%B8%B6%27%2C%27%CF%E7%B2%C6%B9%C9%CE%C4%BA%C5%27%2C1877%2C%27%C6%E4%CB%FB%D6%B8%B1%EA%27%2C%27%C6%E4%CB%FB%D7%CA%BD%F0%27%2C%27%D0%D0%D5%FE%D4%CB%D0%D0%27%2C%27%D2%BB%B0%E3%B9%AB%B9%B2%B7%FE%CE%F1%D6%A7%B3%F6-%D5%FE%B8%AE%B0%EC%B9%AB%CC%FC%A3%A8%CA%D2%A3%A9%BC%B0%CF%E0%B9%D8%BB%FA%B9%B9%CA%C2%CE%F1-%D0%D0%D5%FE%D4%CB%D0%D0%27%2C%27%C6%E4%CB%FB%C9%CC%C6%B7%BA%CD%B7%FE%CE%F1%D6%A7%B3%F6%27%2C%27%BB%FA%B9%D8%C9%CC%C6%B7%BA%CD%B7%FE%CE%F1%D6%A7%B3%F6-%C6%E4%CB%FB%C9%CC%C6%B7%BA%CD%B7%FE%CE%F1%D6%A7%B3%F6%27%2C%27%CA%DA%C8%A8%D6%A7%B8%B6%27%2C%27%CF%E7%D5%F2%D6%A7%B3%F6%27%2C%27%27%2C%27%27%29%3B++++++commit%3B+++++select+iPDh%2B1+into+ierrCount+from+dual+%3B++++Exception+++++when+others+then+++++++RollBack%3B+++++++select+0+into+ierrCount+from+dual+%3B+++end+%3B+++Open+%3ApRecCur+for+++++select+ierrCount+RES%2CszDJBH+DJBH+from+dual%3B++end%3B+end%3B+%3C%2FDATA%3E%3C%2FPARAM%3E%3C%2FPARAMS%3E%3C%2FR9FUNCTION%3E%3C%2FR9PACKET%3E';


    dump($a == $b);
});