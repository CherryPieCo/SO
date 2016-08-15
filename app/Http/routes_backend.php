<?php

Route::group(array(
    'prefix' => config('jarboe.admin.uri'), 
    'before' => array(
        'auth_admin', 
        'check_permissions',
        'csrf_admin'
    )
), function () {

    Route::get('/', 'DashboardController@show');
    Route::post('/', 'DashboardController@process');
    Route::post('/pack/info', 'DashboardController@getPackInfo');
    
    Route::any('packs', 'TableAdminController@showPacks');
    Route::any('settings', 'TableAdminController@settings');
    
    Route::any('links', 'TableAdminController@showLinks');
    
    Route::any('moz', 'TableAdminController@showMozapiAccounts');

});
