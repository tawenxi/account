<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/topics2', function (Request $request) {
    $topics = \App\Model\Account::select(['id', 'name'])
                ->where('name', 'like', '%'.$request->q.'%')->get();

    return $topics;
})->middleware('api');

Route::get('/zfpz/{zfpz}', function ($zfpz) {
	$received = \App\Model\Zfpz::withoutGlobalScopes()->find($zfpz)->received;
    return response()->json(['received' => $received]);
})->middleware('api');


Route::post('/zfpz/receive', function() {
		$zfpz = \App\Model\Zfpz::withoutGlobalScopes()->find(request('zfpz'));
        $received = $zfpz->received;

        if ($received == '1' ) {
            $zfpz->update(['received' => '0']);
        } else {
        	$zfpz->update(['received' => '1']);
        }

        switch ($received) {
            case '1':
                $zfpz->update(['received' => '2']);
                break;
            case '2':
                $zfpz->update(['received' => '0']);
                break;
            case '0':
                $zfpz->update(['received' => '1']);
                break;

        }
        
        return response()->json(['received' => \App\Model\Zfpz::withoutGlobalScopes()->find(request('zfpz'))->received]);
    });



Route::post('/savedata', function(Request $request) {

    return \App\Task::create($request->all());
    

    });

Route::get('/getdata', function() {

    $data = \App\Task::get();
    return response()->json($data);
    });


Route::get('/truncatedata', function() {
    \App\Task::truncate();
    
       
    });





Route::get('/boss/{name}', function () {
    $data = \App\Model\Boss::where('name',request('name'))->first();
    return response()->json($data);
})->middleware('api');

Route::get('/possible/{name}', function () {
    $data = \App\Model\Boss::where('name','like','%'.request('name').'%')->get();
    return response()->json($data);
})->middleware('api');

Route::get('/allboss', function () {
    $data = \App\Model\Boss::all()->map(function($item,$key){
        return [
            'id'=>$key,
            'label'=>$item->name
        ];
    });
    return response()->json($data);
})->middleware('api');

Route::get('/zfpzs/{name}', function () {
    $data = date('Ym',strtotime("-2 month"));
    $data = \App\Model\Zfpz::withoutGlobalScopes()->where('SKR',request('name'))->where('PDQJ','>=',$data)->get();
    return response()->json($data);
})->middleware('api');

Route::get('/unshengxiao', function () {
    $data = date('Ym',strtotime("-2 month"));
    $data = \App\Model\Zfpz::withoutGlobalScopes()->where('qs',0)->where('PDQJ','>=',$data)->get();
    return response()->json($data->toArray());
})->middleware('api');

Route::get('/shengxiao', function () {
    $data = date('Ym',strtotime("-1 month"));
    $data = \App\Model\Zfpz::withoutGlobalScopes()->where('qs',1)->where('PDQJ','>=',$data)->get();
    return response()->json($data->toArray());
})->middleware('api');

Route::get('/validate', function () {
    $data = date('Ym',strtotime("-1 month"));
    $data = \App\Model\Zfpz::withoutGlobalScopes()->where('PDQJ','>=',$data)->get();
    return response()->json($data->toArray());
})->middleware('api');



Route::get('/cacheclear', function () {
        Artisan::call('cache:clear');
        return response()->json(['cacheclear'=>true]);
})->middleware('api');


Route::get('/pullzfpz', function () {
        session(['ND' => config('app.MYND')]);  
        Artisan::call('pull:zfpz');
        return response()->json(['pullzfpz'=>true]);
})->middleware('api');   

Route::get('/pullsq', function () {
        session(['ND' => config('app.MYND')]);  
        Artisan::call('pull:sq');
        return response()->json(['pullsq'=>true]);
})->middleware('api');

Route::get('/pullzj', function () {
        session(['ND' => config('app.MYND')]);  
        Artisan::call('pull:zj');
        return response()->json(['pullzj'=>true]);
})->middleware('api');

Route::get('/updateboss', function () {
        session(['ND' => config('app.MYND')]);  
        Artisan::call('pull:updateboss');
        return response()->json(['updateboss'=>true]);
})->middleware('api');

Route::get('/pullyue', function () {
        session(['ND' => config('app.MYND')]);  
        Artisan::call('pull:yue');
        return response()->json(['pullyue'=>true]);
})->middleware('api');

Route::get('/pullshenqing', function () {
        session(['ND' => config('app.MYND')]);  
        Artisan::call('pull:shenqing');
        return response()->json(['pullshenqing'=>true]);
})->middleware('api');

Route::get('/pullcast', function () {
        session(['ND' => config('app.MYND')]);  
        Artisan::call('pull:cast');
        return response()->json(['pullcast'=>true]);
})->middleware('api');

Route::get('/pulldpt', function () {
        session(['ND' => config('app.MYND')]);  
        Artisan::call('pull:dpt');
        return response()->json(['pulldpt'=>true]);
})->middleware('api');