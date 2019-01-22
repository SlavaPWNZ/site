<?php
Route::resource('/', 'MenuController');
Route::resource('/pregtest', 'PregReplace');
Route::post('/action', 'AjaxController@main');
Route::any('{all}', 'MenuController@index');
