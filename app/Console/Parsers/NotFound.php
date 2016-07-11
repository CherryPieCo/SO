<?php

namespace App\Console\Parsers;

use \RollingCurl\Request;
use \RollingCurl\RollingCurl;


class NotFound extends AbstractParser
{
    
    public $type = 'not_found';
    protected $signature = 'scrape:not_found {url : site url} {options : options} {--pack= : pack id}';
    protected $description = 'scrape:not_found ex.com';

    public function exec()
    {
        $this->idPack = $this->option('pack');
        $data = [];
        
        $links = $this->getLinksFromPage($this->url);
        if ($links) {
            $rollingCurl = new RollingCurl();
            
            foreach ($links as $link) {
                $rollingCurl->get($link);
            }

            $rollingCurl->setCallback(function(Request $request, RollingCurl $rollingCurl) use(&$data) {
                $responseInfo = $request->getResponseInfo();
                $httpCode = $responseInfo['http_code'];
                $url = $responseInfo['url'];
    
                if (in_array($httpCode, array(0,404))) {
                    $data[] = $url;
                }
    
                $rollingCurl->clearCompleted();
                $rollingCurl->prunePendingRequestQueue();
            })->execute();
        }

        $data = array_unique(array_filter($data));
        $this->data = $data;
        
        $parsers = $this->site->parsers;
        $values['updated_at'] = time();
        $parsers['not_found'] = $data;
        $this->site->parsers = $parsers;
        $this->site->save();
    } // end exec
    
    private function getLinksFromPage($url)
    {
        $pUrl = parse_url($url);
        $doc = new \DOMDocument();

        @$doc->loadHTMLFile($url);
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

        return $result;
    } // end getLinksFromPage
    
    protected function isApiRequestSuccessful()
    {
        return isset($this->data) && !empty($this->data);
    } // end isApiRequestSuccessful
    
}
    