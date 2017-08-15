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

// 通用路由
Route::group(['namespace'=>'MySearch'], function(){

    Route::get('/index', 'Cindex@index');
    Route::get('/test', function(){
        return view('Test.test1');
    });

});
