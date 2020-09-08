<?php
/**
 * Created by PhpStorm.
 * User: yuse
 * Date: 19/3/31
 * Time: 下午9:54
 */
Route::post('/form/apply', 'FormController@apply');
Route::get('/form/getexcel/{job}', 'FormController@getExcel');



Route::post('/form/applyteam', 'FormController@applyTeam');
Route::get('/form/getteamexcel/{flag}', 'FormController@getTeamExcel');


Route::post('/t', 'FormController@t');