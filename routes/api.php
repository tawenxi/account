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
	$received = \App\Model\Zfpz::find($zfpz)->received;
    return response()->json(['received' => $received]);
})->middleware('api');


Route::post('/zfpz/receive', function() {
		$zfpz = \App\Model\Zfpz::find(request('zfpz'));
        $received = $zfpz->received;

        if ($received == '1' ) {
            $zfpz->update(['received' => '0']);
        } else {
        	$zfpz->update(['received' => '1']);
        }
        
        return response()->json(['received' => \App\Model\Zfpz::find(request('zfpz'))->received]);
    });