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
Route::group(['domain' => 'search.suhanyu.dev', 'namespace' => 'MySearch'], function () {

    Route::get('/search/index', 'Cindex@getData');
    // 内容的存储
    Route::match(['post'], '/article/store', 'Cindex@store');
    Route::match(['get'], '/test', function (){
        return view('Test.test1');
    });
    // 从es中获取一条数据
    Route::get('/getData/{id}', 'Cindex@getData');

});

Route::group(['domain' => 'test.suhanyu.dev'], function () {
    Route::get('/index', function () {
        return [
            'domain' => 'this domain is "test"'
        ];
    });
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/', function () {
    return view('welcome');
});

