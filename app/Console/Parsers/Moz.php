<?php

namespace App\Console\Parsers;

use App\Models\MozCredentials;
use App\Models\MozMetrics;
use App\Helpers\Alexa; 


class Moz extends AbstractParser
{
    
    const PAGE_AUTHORITY = 34359738368;
    const DOMAIN_AUTHORITY = 68719476736;
    
    public $type = 'moz';
    protected $signature = 'scrape:moz {url : site url} {options : options list} {--pack= : pack id}';
    protected $description = 'scrape:moz ex.com page_authority-domain_authority';
    private $options = [];
    
    private $allowedAttributes = [
        'pda',
        'upa',
    ];
    
    
    private function getPageAuthorityKey()
    {
        return in_array('page_authority', $this->options) ? self::PAGE_AUTHORITY : 0;
    } // end getPageAuthorityKey
    
    private function getDomainAuthorityKey()
    {
        return in_array('domain_authority', $this->options) ? self::DOMAIN_AUTHORITY : 0;
    } // end getDomainAuthorityKey
    
    private function validateOptions($options)
    {
        return in_array('page_authority', $options) || in_array('domain_authority', $options);
    } // end validateOptions
    
    public function exec()
    {
        $this->idPack = $this->option('pack');
        $this->options = explode('-', $this->argument('options'));
        
        if (true || !$this->validateOptions($this->options)) { 
            $this->data = [];
            $this->finish();
            return;
        }
        
        // HACK: parse all for cache sanity
        $this->options = [
            'page_authority',
            'domain_authority',
        ];
        
        
        if (!MozCredentials::where('status', 'ok')->count()) {
            throw new \RuntimeException('No available MOZ accounts');
        }
        
        $credentials = MozCredentials::available()->first();
        while (!$credentials) {
            if (!MozCredentials::where('status', 'ok')->count()) {
                throw new \RuntimeException('No available MOZ accounts');
            }

            sleep(1);
            $credentials = MozCredentials::available()->first();
        }
        $credentials->markAsUsed();
        
        $accessID = $credentials->access_id;
        $secretKey = $credentials->secret_key;     
        //
        $expires = time() + 300;
        $stringToSign = $accessID."\n".$expires;
        $binarySignature = hash_hmac('sha1', $stringToSign, $secretKey, true);
        $urlSafeSignature = urlencode(base64_encode($binarySignature));
        $cols = $this->getPageAuthorityKey() + $this->getDomainAuthorityKey();
        $requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/".urlencode($this->url)."?Cols=".$cols."&AccessID=".$accessID."&Expires=".$expires."&Signature=".$urlSafeSignature;
        // Use Curl to send off your request.
                
                
        $metrics = $this->getMozResponse($requestUrl);
        if (!$metrics) {
            throw new \RuntimeException(sprintf('No response from moz: [%s]', $requestUrl));
        } elseif (isset($metrics['error_message'])) {
            $credentials->addError($metrics);
            throw new \RuntimeException(sprintf('Moz api: [%s]', $metrics['error_message']));
        }
        
        //
        $values = [];
        foreach ($metrics as $attribute => $value) {
            if (!in_array($attribute, $this->allowedAttributes)) {
                continue;
            }
            $values[$attribute] = $value;
        }
        
        $this->data = $values;
        
        $this->finish();
    } // end exec
    
    private function finish()
    {
        $parsers = $this->site->parsers;
        $values['updated_at'] = time();
        $parsers['moz'] = $this->data;
        $this->site->parsers = $parsers;
        $this->site->save();
    } // end finish
    
    public function getMozResponse($url)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true
        ]);
        $content = curl_exec($ch);
        curl_close($ch);
        
        return json_decode($content, true);
    } // end getMozResponse
    
}
    