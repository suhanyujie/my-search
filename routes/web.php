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


// 通用路由
Route::group(['domain' => 'search.suhanyu.deve', 'namespace' => 'MySearch'], function () {
    //首页
    Route::match(['get'], '/test', function (){
        return view('Test.test1');
    });
    // 内容的存储
    Route::match(['post'], '/article/store', 'Cindex@store');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/', function () {
    return view('welcome');
});

