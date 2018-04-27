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


Route::get('/boss/{name}', function () {
    $data = \App\Model\Boss::where('name',request('name'))->first();
    return response()->json($data);
})->middleware('api');

Route::get('/unshengxiao', function () {
    $data = date('Ym',strtotime("-1 month"));
    $data = \App\Model\Zfpz::where('qs',0)->where('PDQJ','>=',$data)->get();
    return response()->json($data->toArray());
})->middleware('api');

Route::get('/shengxiao', function () {
    $data = date('Ym',strtotime("-1 month"));
    $data = \App\Model\Zfpz::where('qs',1)->where('PDQJ','>=',$data)->get();
    return response()->json($data->toArray());
})->middleware('api');