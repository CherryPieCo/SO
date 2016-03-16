<?php

namespace App;


class ScrapeCallback 
{
    
    private $url = '';
    private $request;
    private $curl;
    private $options = [];
    
    public function __construct(\RollingCurl\Request $request, \RollingCurl\RollingCurl $rollingCurl, array $options, $url)
    {
        $this->request = $request;
        $this->curl    = $rollingCurl;
        $this->options = $options;
        $this->url     = $url;
    } // end __construct
    
    public function run()
    {
        foreach ($this->options as $option) {
            $class = '\\App\\Parsers\\'. studly_case($option);
            
            $parser = new $class($this->request, $this->curl, $this->url);
            $parser->exec();
        }
    } // end run
    
}

