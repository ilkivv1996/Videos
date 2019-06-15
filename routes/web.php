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


Route::get('/', 'VideoController@index')->name('index'); // главная

//Route::get('/videos', 'VideoController@list_youtube')->name('list_youtube'); // список видео

Route::get('/videos/{url}', 'VideoController@video_category')->name('video_category'); // список видео по категории

Route::get('/videos/{url1}/{url2}', 'VideoController@video')->name('video'); // просмотр одного видео

Route::post('/search', 'VideoController@search')->name('search'); // просмотр одного видео

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('sitemap.xml', 'SitemapController@sitemapIndex');