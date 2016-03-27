<?php


Route::group(['prefix' => 'api', 'middleware' => 'jwt.auth'], function()
{
    Route::get('email/{anything}', function($url) {
        $user = JWTAuth::parseToken()->toUser();
        
        if (!parse_url($url, PHP_URL_SCHEME)) {
            return response()->json([
                'error' => 'Urls without scheme are not allowed.'
            ], 422);
        }
        
        
        $site = App\Models\Url::where('url', $url)->first();
        if (!$site) {
            Artisan::call('scrape:email', [
                'url' => $url
            ]);
            
            $site = App\Models\Url::where('url', $url)->first();
        }
        $parsers = $site->parsers;
        $data = [
            'url' => $site->url,
            'emails' => array_get($parsers, 'email.emails', []),
            'contacts' => array_get($parsers, 'email.contacts', []),
            'created_at' => $site->created_at,
        ];
        return response()->json(compact('data'));
    });
    
});

