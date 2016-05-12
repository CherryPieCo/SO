<?php

Route::pattern('id', '[0-9]+');
Route::pattern('slug', '[A-Za-z0-9-_]+');
Route::pattern('base64', '^(?:[A-Za-z0-9+/]{4})*(?:[A-Za-z0-9+/]{2}==|[A-Za-z0-9+/]{3}=)?$');
Route::pattern('anything', '.+');


include_once 'routes_backend.php';
include_once 'routes_api.php';
if (file_exists(__DIR__ .'/routes_dev.php')) {
    include __DIR__ .'/routes_dev.php';
}

Route::filter('auth', function() {
    if (!Sentinel::check()) {
        if (Request::ajax()) {
            return Response::make('Unauthorized', 401);
        } else {
            return Redirect::guest('/');
        }
    }
});


Route::group([
    'prefix' => 'me', 
    'before' => ['auth'],
], function () {
    
    Route::get('/bulk', 'SoController@showBulk');
    Route::get('/bulk/{slug}/xls/download', 'SoController@downloadBulkXls');
    Route::get('/api', 'SoController@showApi');
    
    Route::post('/create-bulk', 'SoController@createBulk');
    Route::post('/remove-bulk', 'SoController@removeBulk');
    Route::post('/set-bulks-per-page-count', 'SoController@setBulksPerPageCount');
    
    Route::get('/logout', function() {
        Sentinel::logout();
        return redirect('/');
    });

});


Route::get('/', 'HomeController@showIndex');
Route::post('/create-account', 'HomeController@createAccount');
Route::post('/login', 'HomeController@login');

