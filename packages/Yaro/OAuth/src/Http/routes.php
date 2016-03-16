<?php


Route::post('/_oauth/google', function() {
    dr(OAuth::google()->email);
});
Route::get('/_oauth/google/redirect', function() {
    return;
});


Route::post('/_oauth/facebook', function() {
    dr(OAuth::facebook());
});
Route::get('/_oauth/facebook/redirect', function() {
    return;
});

Route::post('/_oauth/yahoo', function() {
    dr(OAuth::facebook());
});
Route::get('/_oauth/yahoo/redirect', function() {
    return;
});