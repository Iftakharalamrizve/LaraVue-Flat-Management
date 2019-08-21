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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResources(['profile' => 'API\ProfileController']);
Route::apiResources(['users' => 'API\UserController']);
Route::apiResources(['millexpense' => 'API\MillAccountController']);
Route::apiResources(['mill' => 'API\MillController']);
//extra method 
Route::get('millexpense-chagestatus/{index}','API\MillAccountController@cangeStatus');
Route::get('mill-history/{month}','API\MillController@millHistoryByMonth');
Route::get('totalMill/{month}','API\MillController@TotalUserMill');
Route::get('search/user/{field}/{query}','API\UserController@search');
// Route::get('profile', 'API\ProfileController@profile');
Route::get('diposite_user/{id}/{month}', 'API\MillAccountController@findDeposite');
Route::post('updateMill/', 'API\MillController@updateMill');
Route::get('report/', 'ReportController@index');