<?php
/**
 * Created by PhpStorm.
 * User: yuse
 * Date: 19/3/31
 * Time: 下午9:54
 */
Route::post('/form/apply', 'FormController@apply');
Route::get('/form/getexcel/{job}', 'FormController@getExcel');