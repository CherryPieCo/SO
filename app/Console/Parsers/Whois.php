<?php

namespace App\Console\Parsers;

use App\Models\MozCredentials;
use App\Models\MozMetrics;


class Whois extends AbstractParser
{

    protected $signature = 'scrape:whois {url : site url}';
    protected $description = 'Command description';
    
    
    public function exec()
    {
        
    } // end exec
    
}
    