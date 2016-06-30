<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        throw new \Exception("Error Processing Request", 1);
        
        $pUrl = parse_url('http://www.pasadenaisd.org/sailon/grade8.htm');
        $doc = new \DOMDocument();
    
        @$doc->loadHTMLFile('http://www.pasadenaisd.org/sailon/grade8.htm');
        $links = $doc->getElementsByTagName('a') ?: [];
    
        $result = [];
        foreach ($links as $link) {
            preg_match_all('/\S+/', strtolower($link->getAttribute('rel')), $rel);
            if (!$link->hasAttribute('href') || in_array('nofollow', $rel[0])) {
                continue;
            }
    
            $href = $link->getAttribute('href');
            if (substr($href, 0, 2) === '//') {
                $href = $pUrl['scheme'] . ':' . $href;
            }
    
            $pHref = parse_url($href);
    
            if (!$pHref || !isset($pHref['host']) ||
                strtolower($pHref['host']) === strtolower($pUrl['host'])
            ) {
                continue;
            }
    
            $x = $link->getAttribute('href');
    
            $result[] = $x;
        }
        
        $data = [];
        $links = $result;
        $rollingCurl = new \RollingCurl\RollingCurl();
        $rollingCurl->setOptions(array(
            CURLOPT_FOLLOWLOCATION  => true,
        ));
        foreach ($links as $link) {
            $rollingCurl->get($link);
        }
        ob_start();
        $rollingCurl->setCallback(function(\RollingCurl\Request $request, \RollingCurl\RollingCurl $rollingCurl) use(&$data) {
            $responseInfo = $request->getResponseInfo();
            $httpCode = $responseInfo['http_code'];
            $url = $responseInfo['url'];
    
            //echo  $responseInfo['http_code'] .' | '. $url .PHP_EOL;
            $data[$responseInfo['http_code']][] = $url;
            if (in_array($httpCode, array(0,404))) {
                //$data[] = $url;
                //echo '<li>'. $url;
            }
    
            //$rollingCurl->clearCompleted();
            //$rollingCurl->prunePendingRequestQueue();
        })->execute();
        ob_clean();
        dr($data);
    }
}
