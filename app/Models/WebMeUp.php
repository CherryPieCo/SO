<?php

namespace App\Models;

use InvalidArgumentException;


class WebMeUp 
{
    
    const API_URL = 'http://webmeup.com/partners/backlinks-api/request/1.0/';
    
    private $url    = '';
    private $mode   = '';
    private $apiKey = '';
    private $method = 'get-backlinks';
    
    
    public function __construct($apiKey)
    {
        if (!$apiKey) {
            throw new InvalidArgumentException('WebMeUp: Api key is required');
        }
        
        $this->apiKey = $apiKey;
    } // end __construct
    
    public function backlinks()
    {
        $this->method = 'get-backlinks';
        
        return $this;
    } // end backlinks
    
    public function url($url)
    {
        $this->url = urlencode($url);
        
        return $this;
    } // end url
    
    public function statistics()
    {
        $this->method = 'get-backlink-statistics';
        
        return $this;
    } // end statistics
    
    public function mode($mode)
    {
        switch ($mode) {
            case 'exactUrl':
                $this->mode = 'exactUrl';
                break;
                
            case 'domainWithSubdomains':
                $this->mode = 'domainWithSubdomains';
                break;
            
            default:
                $this->mode = 'exactDomain';
        }
        
        return $this;
    } // end mode
    
    public function get($fields = 'url')
    {
        $requestUrl = self::API_URL . $this->method
                    . '?partnerAPIKey=' . $this->apiKey
                    . '&mode=' . $this->mode 
                    . '&url=' . $this->url
                    . '&fields=' . $fields
                    . '&format=json';
        $response = file_get_contents($requestUrl);
        $data = json_decode($response, true);
        
        return $data;
    } // end get
    
    
}

