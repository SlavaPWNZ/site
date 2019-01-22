<?php
Route::resource('/', 'MenuController');
Route::resource('/pregtest', 'PregReplace');
Route::post('/action', 'AjaxController@store');
Route::any('{all}', 'MenuController@index');
