<?php
Route::get('/', function () {
    return view('main');
});
Route::resource('/pregtest', 'PregReplace');
Route::post('/action', 'AjaxController@store');
Route::any('{all}', function () {
    return view('main');
});