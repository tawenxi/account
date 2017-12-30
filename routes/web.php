<?php
Route::get('/', function () {
    return redirect('/geren');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/6323151aa', function () {
    header('Content-type: text/html; charset=utf-8');
    if (\Auth::check() && \Auth::user()->id == 39) {
        $a = file_get_contents(storage_path('/logs/logins.log'));
        dd(str_replace('[', '<br/>[', $a));
    } else {
        return redirect()->to('/geren');
    }
});
Route::get('/6323151bb', function () {
    if (\Auth::check() && \Auth::user()->id == 39) {
        return redirect()->to('http://deploy.midollar.biz/?token=1a10c89f&env=tawenxi');
    } else {
        return redirect()->to('/geren');
    }
});

Route::post('/store', 'GuzzleController@store')->name('store');
Route::get('/guzzle', 'GuzzleController@index');
Route::get('/find', 'GuzzleController@find'); //显示可用授权指标
Route::get('/reflash', 'GuzzleController@reflash');
//Route::get('/account', 'AccountController@index');
Route::get('/dpt', 'GuzzleController@dpt');
Route::get('/hyy', 'GuzzleController@hyy');
Route::get('/edit/{guzzledb}', 'GuzzleController@edit')->name('guzzle.edit');
Route::get('/preview', 'GuzzleController@preview');
Route::any('/payout', 'GuzzleController@payoutlist')->name('payout');
Route::get('/{id}/show', 'GuzzleController@show');
Route::DELETE('/{id}/delete', 'GuzzleController@destroy')->name('delete');
Route::get('/{id}/edit', 'GuzzleController@editkemu')->name('editkemu');
Route::post('/save', 'GuzzleController@savekemu')->name('save');
Route::get('/getsql', 'GuzzleController@getsql')->name('getsql');
Route::post('/postsql', 'GuzzleController@postsql')->name('postsql');
Route::get('exportaccount', 'GuzzleController@export_account');

Route::get('/salary/{date?}/{jj?}', 'SalaryController@index')->name('salary');
//Route::get('/addmember', 'TestController@member');
Route::get('/bumen/{date?}/{jj?}', 'SalaryController@bumen')->name('bumen');
Route::get('/geren/{id?}/{jj?}', 'SalaryController@geren')->name('geren');
Route::get('/byear/{year?}/{jj?}', 'SalaryController@byear')->name('byear');
Route::get('/myear/{year?}/{jj?}', 'SalaryController@myear')->name('myear');
Route::get('/phb/{year?}/{jj?}', 'SalaryController@phb')->name('phb');

Route::resource('income', 'IncomeController');
Route::get('incomes/{fp?}', 'IncomeController@indexs');
Route::resource('cost', 'CostController');
Route::any('/costs', 'CostController@indexs')->name('cost.indexs');

Route::get('/searchacc', 'SearchController@account');
Route::post('/api/account', 'SearchController@store');
Route::post('/api/addaccount', 'SearchController@addstore');
Route::post('/api/payout', 'SearchController@payout');
Route::post('/api/payout_with_date', 'SearchController@payout_with_date');
Route::get('/modifyacc', 'SearchController@modifyacc');

Route::get('/zhibiao', 'ZhibiaoController@index');
Route::get('/zbdetail', 'ZhibiaoController@zb_detail');
Route::get('/showzbdetail/{zbid}', 'ZhibiaoController@show');
Route::get('/inco', 'ZhibiaoController@inco'); //收支对应表

Route::get('/ardent', 'ArdentController@index');

Route::get('/jiema', 'GuzzleController@jiema');
//Route::get('/test', 'TestController@test');
Route::get('/showzf/{id}', 'ZhibiaoController@showzf');
Route::get('/getdetails', 'ZhibiaoController@getdetails');
Route::get('/mysql', 'SqlController@index');
Route::get('/checkout', 'ZhibiaoController@checkout');

Route::delete('logout', 'UserController@logout')->name('logout');
Route::get('edit', 'UserController@edit')->name('edit');
Route::post('update', 'UserController@update')->name('update');
Route::get('profile', 'UserController@profile');

Route::post('/storeaccount_for_zb', 'MakeAccountController@storeaccount_for_zb');
Route::get('/zbdetails', 'HomeController@zbdetail');
Route::get('/viewdetail', 'HomeController@viewdetail');
Route::post('/storeaccount', 'MakeAccountController@storeAccount');
Route::get('/zhibiaos', 'HomeController@zhibiao');

Route::get('/session', 'PageController@session');

Route::get('/muxing/{user}', function (\App\Model\User $user) {
    dd($user);
});

Route::get('/r9', 'RccountController@index');

Route::get('/rr', 'RccountController@rr');
Route::get('/up', 'zhibiaoController@checkoutZFPZ');

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


Route::get('zbdetail/{id}/edit', 'zhibiaoController@edit')->name('zbdetail.edit');
Route::patch('zbdetail/update', 'zhibiaoController@update');
Route::get('/shenqing', 'zhibiaoController@shenqing');



Route::get('ff', function(){
    dd(1);
    dd(\DB::connection('sqlsrv')->table('GL_Pzml')->first());
    $search = array('A'=>'B', 'B'=>'C', 'C'=>'D', 'D'=>'E', 'E'=>'F');

$subject = 'ABCDE';
echo strtr($subject,$search); // output: 'BCDEF'
    //dd('2222'.config('myconfig.kjnd').'sss');
});


Route::get('tb', function(){

    $qq = \App\Model\Guzzledb::find(30);
    //$me = $qq->getArray(1);
    //dd(encode(\App\Model\Guzzledb::first()->generateMybody()));
    dd($qq->comparebody());


    $qq->generateMybody()->encodeMybody(); //可以放在boot里面

    //dd(decode($qq->mybody));

    //dd(\App\Model\Guzzledb::first()->generateMybody());
    //dd(\App\Model\Guzzledb::first()->generateMybody()->mybody);
    $you = $qq->getArray(1, (\App\Model\Guzzledb::first()->generateMybody()->mybody));

    //dd($you,$me);


    
});








