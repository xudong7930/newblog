<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/download', 'DownloadController@show')->name('download.show');
Route::post('/download', 'DownloadController@run')->name('download.run');