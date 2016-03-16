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
    
    Route::any('packs', 'TableAdminController@showPacks');
    

});
