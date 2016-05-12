<?php

namespace App\Console\Parsers;


class Backlinks extends AbstractParser
{
    public $type = 'backlinks';
    protected $signature = 'scrape:backlinks {url : site url} {--pack= : pack id}';
    protected $description = 'scrape:backlinks example.com';
    
    public function exec()
    {
        $this->idPack = $this->option('pack');
        
        $backlinks = $this->getBacklinks();

        $parsers = $this->site->parsers;
        $parsers[$this->type] = [
            'urls' => array_filter($backlinks),
            'updated_at' => time(),
        ];
        $this->site->parsers = $parsers;
        $this->site->save();
        
        
        $this->data = [
            'urls' => array_filter($backlinks),
        ];
    } // end exec
    
    private function getBacklinks()
    {
        $requestUrl = 'http://webmeup.com/partners/backlinks-api/request/1.0/get-backlinks?'
                    . 'partnerAPIKey=' . '4fd7428f-bc7f-49f9-85bc-7282bfaс'
                    . '&url=' . urlencode($this->url)
                    . '&fields=url'
                    . '&format=json';
        $response = file_get_contents($requestUrl);
        $data = json_decode($response, true);
        
        $urls = [];
        // FIXME:
        if (isset($data['backlinks'])) {
            foreach ($data['backlinks'] as $url) {
                $urls[] = $url['url'];
            }
        }
        
        return $urls;
    } // end getBacklinks
    
    protected function isApiRequestSuccessful()
    {
        return isset($this->data['urls']) && !empty($this->data['urls']);
    } // end isApiRequestSuccessful
    
}

