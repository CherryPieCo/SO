<?php


Route::group(['prefix' => 'api', 'middleware' => 'jwt.auth'], function()
{
    Route::get('me', function() {
        $user = \JWTAuth::parseToken()->toUser();
        
        $data = [
            'first_name' => $user->first_name,
            'last_name'  => $user->last_name,
            'email'      => $user->email,
        ];
        return response()->json(compact('data'));
    });
    
    Route::get('email/{anything}', function($url) {
        $user = JWTAuth::parseToken()->toUser();
        $url = urldecode($url);
        
        if (!parse_url($url, PHP_URL_SCHEME)) {
            return response()->json([
                'error' => 'Urls without scheme are not allowed.'
            ], 422);
        }
        
        // FIXME: reparse if time
        $site = App\Models\Url::where('hash', md5($url))->first();
        if (!$site) {
            Artisan::call('scrape:email', [
                'url' => $url
            ]);
            
            $site = App\Models\Url::where('hash', md5($url))->first();
        }
        $parsers = $site->parsers;
        $data = [
            'url' => $site->url,
            'emails' => array_get($parsers, 'email.emails', []),
            'contacts' => array_get($parsers, 'email.contacts', []),
        ];
        
        return response()->json(compact('data'));
    });
    
});

