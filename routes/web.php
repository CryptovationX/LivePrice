<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('test/{id}', 'TestController@test');
Route::get('line', 'TestController@line');
Route::get('arbi', 'TestController@arbi');
Route::get('line/webhooks', 'Line\LINEController@receive');
Route::post('webhooks', 'Line\LINEController@receive');
