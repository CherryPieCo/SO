<?php


Route::group(['prefix' => 'api', 'middleware' => 'api.auth'], function()
{
    Route::get('me', 'ApiController@me');
    Route::get('email/{anything}', 'ApiController@email');
    
});

