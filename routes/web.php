<?php

Route::get('/', function () {return redirect('/zhibiao/?search=yeamount:1&orderBy=LR_RQ');});
Route::get('/jiema', 'GuzzleController@jiema');
require('myweb.php');
Route::get('/2', function () {
    $data = date('Ym',strtotime("-2 month"));
    dd($data);
});

Route::get('users/{userid}/activity', 'ActivityController@show');

Auth::routes();

Route::get('project/{project_id}/project-payout', 'ZhibiaoController@project_payout');
Route::get('project/{project_id}/project-income', 'ProjectController@project_income');

Route::resource('project', 'ProjectController');
Route::get('village', 'ProjectController@village');
Route::get('divider/{zb}', 'ProjectController@divider');
Route::put('divider', 'ProjectController@handleDivider')->name('project.divider');
Route::post('deletezb', 'ProjectController@deletezb')->name('project.deletezb');

Route::get('point/{zb}', 'ProjectController@point');
Route::put('point', 'ProjectController@handlepoint')->name('project.point');



Route::get('/home', 'HomeController@index')->name('home');

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
Route::get('/zbdetail', 'ZhibiaoController@zb_detail')->middleware('cache.response');
Route::get('/showzbdetail/{zbid}', 'ZhibiaoController@show');
Route::get('/inco', 'ZhibiaoController@inco'); //收支对应表

Route::get('/ardent', 'ArdentController@index');


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
Route::get('/r9', 'RccountController@index');
Route::get('/rr', 'RccountController@rr');
Route::get('/up', 'ZhibiaoController@checkoutZFPZ');
Route::get('zbdetail/{id}/edit', 'ZhibiaoController@edit')->name('zbdetail.edit');
Route::patch('zbdetail/update', 'ZhibiaoController@update');
Route::get('/shenqing', 'ZhibiaoController@shenqing');

Route::get('/company', 'BossController@companylist');
Route::get('/personalboss', 'BossController@personalbosslist');

Route::get('/boss', 'BossController@bosslist');

Route::get('/poorboss', 'BossController@poorbosslist');
Route::get('/jingguanzhan/boss/{personal?}', 'BossController@jingguanzhan');
Route::get('/{boss}/boss/{supportpoor?}', 'BossController@bossDetail');
Route::get('/boss/{boss}/edit', 'BossController@edit')->name('boss.edit');
Route::post('boss/store', 'BossController@update')->name('boss.update');

Route::get('/project/tozfl/{village?}', 'BossController@villagezfl');
Route::view('redis', 'zhibiao.socket');
Route::get('rediscache', 'ZhibiaoController@rediscache');
Route::get('zhijie', 'ZhibiaoController@zhijie');

Route::get('es', 'SearchController@search');
Route::view('taskmanager', 'task.index');

Route::get('blade', 'ZhibiaoController@blade');

Route::get('sourcezb/{zbid}', 'ZhibiaoController@sourcezb');

Route::get('pullzhifupz', 'CommandController@pullzhifupz');
Route::get('pullsq', 'CommandController@pullsq');
Route::get('pullzj', 'CommandController@pullzj');
Route::get('updateboss', 'CommandController@updateboss');
Route::get('pullyue', 'CommandController@pullyue');
Route::get('pullshenqing', 'CommandController@pullshenqing');
Route::get('cast', 'CommandController@cast');
Route::get('cacheclear', 'CommandController@cacheclear');
Route::get('file/{id}', 'FileController@index');
Route::post('/file-upload', 'FileController@uploadFile')->name('store_file_path');
Route::get('/deletefile/{id}', 'FileController@deleteFile');

Route::get('zbhavefile','ZhibiaoController@ZbHavingFile');

Route::get('/overview','ZhibiaoController@overview');
Route::get('searchaccount', 'AccountController@search');
Route::get('searchbalance', 'AccountController@balance')->middleware('cache.response');

Route::get('ssss',function() {


$query = 5000;
$a = \DB::table('zfpzs')
        ->select('ZY', \DB::raw('SUM(`JE`) as JE2'),'SKR','PDRQ')
        ->groupBy(['ZY','SKR','PDRQ'])
        ->havingRaw("JE2 = {$query} AND Count(*) > 1")
        ->get();


$a = \DB::table('zfpzs')
        ->select('SKR as name', \DB::raw('SUM(`JE`) as JE2'))
        ->groupBy(['SKR'])
        //->havingRaw("JE2 = {$query} AND Count(*) > 1")
        ->get();

        dd($a);

});


Route::get('excel','FileController@findexcel');