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
    
    // 内容的搜索
    Route::get('/search/{keyword}', 'Cindex@search');
    // 内容的存储
    Route::match(['post'], '/article/store', 'Cindex@store');
    Route::match(['get'], '/test', function (){
        return view('Test.test1');
    });

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

