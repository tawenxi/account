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
    

    $a = config('app.MYND');
    return $a;
});



Route::get('aaa', function(){
    

      $data = \DB::table('zfpzs')
                 ->select(DB::raw('LEFT(QS_RQ,6) as peroid, count(*) as count, round(sum(JE)/100,2) as amount'))
                 ->where('qs',1)
                 ->groupBy('peroid')
                 ->get()->toarray();

                 dd($data);
});


Route::get('bbb', function(){
    

      $data = \DB::table('zbs')
                 ->select(DB::raw('LEFT(SH_RQ,6) as peroid, count(*) as count, round(sum(JE)/100,2) as amount'))
                 ->groupBy('peroid')
                 ->get()->toarray();

                 dd($data);
});