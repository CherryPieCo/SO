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

Route::get('/', function() {
    return '<html><head><title>wut</title></head><body><a href="http://web.cherry-pie.co/ass">404</a><a href="http://web.cherry-pie.co/">200</a></body></html>';
});
Route::get('/info', function() {
    phpinfo();die;
});

Route::get('/zz', function() {
    //phpinfo();die;
    // $client = new \MongoClient('mongodb://root:pass@localhost:27017/test');
    // $db = $client->test;
    // $collection = $db->movie;
    // $cursor = $collection->find();
    // foreach ($cursor as $d) {
        // print_r($d);
        // echo '<hr>';
    // }
    // die;
    // \DB::connection('mongodb')->collection('movie')->insert([
        // 'title' => 'Title #2',
        // 'year' => 2022,
        // 'actors' => [],
        // 'is_active' => false,
    // ]);
    //$col = \DB::connection('mongodb')->collection('movie')->get();
    dr(App\Models\Pack::where('data.a69c632ffd07101c5096d467b4032ded.url', '!=', 'dd')->first());
    
    $rollingCurl = new \RollingCurl\RollingCurl();
    $rollingCurl->get('http://highscalability.com/blog/2012/2/6/the-design-of-99designs-a-clean-tens-of-millions-pageviews-a.html');
    $rollingCurl->setSimultaneousLimit(2);
    $rollingCurl->setCallback(function(\RollingCurl\Request $request, \RollingCurl\RollingCurl $rollingCurl) use($context) {
        $context->prepare($request, $rollingCurl);
        $context->check();
        $context->exec();
        $context->after();
    });
    $rollingCurl->execute();
    
    
    
    
    
    
    
    
    
    
    
    
    
    // Get your access id and secret key here: https://moz.com/products/api/keys
    $accessID = "mozscape-1123e7610c";
    $secretKey = "2cd1e4029073067a5a779524f21970b7";
    // Set your expires times for several minutes into the future.
    // An expires time excessively far in the future will not be honored by the Mozscape API.
    $expires = time() + 300;
    // Put each parameter on a new line.
    $stringToSign = $accessID."\n".$expires;
    // Get the "raw" or binary output of the hmac hash.
    $binarySignature = hash_hmac('sha1', $stringToSign, $secretKey, true);
    // Base64-encode it and then url-encode that.
    $urlSafeSignature = urlencode(base64_encode($binarySignature));
    // Specify the URL that you want link metrics for.
    $objectURL = "www.seomoz.org";
    // Add up all the bit flags you want returned.
    // Learn more here: https://moz.com/help/guides/moz-api/mozscape/api-reference/url-metrics
    $cols = "103079215108";
    // Put it all together and you get your request URL.
    // This example uses the Mozscape URL Metrics API.
    $requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/".urlencode($objectURL)."?Cols=".$cols."&AccessID=".$accessID."&Expires=".$expires."&Signature=".$urlSafeSignature;
    // Use Curl to send off your request.
    $options = array(
        CURLOPT_RETURNTRANSFER => true
        );
    $ch = curl_init($requestUrl);
    curl_setopt_array($ch, $options);
    $content = curl_exec($ch);
    curl_close($ch);
    print_r($content);
});

