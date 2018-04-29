<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('/download/filelist', 'DownloadController@filelist')->name('download.filelist');
Route::delete('/download/filelist/{title}', 'DownloadController@fileDestroy')->name('file.destroy');
Route::get('/download', 'DownloadController@show')->name('download.show');
Route::get('/download/queue', 'DownloadController@queue')->name('download.queue');
Route::post('/download', 'DownloadController@run')->name('download.run');
Route::delete('/jobs/{id}', 'DownloadController@jobDestroy')->name('job.destroy');