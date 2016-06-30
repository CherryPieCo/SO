<?php

namespace App\Console\Parsers;

use App\Models\WebMeUp;


class Backlinks extends AbstractParser
{
    public $type = 'backlinks';
    private $options = [];
    protected $signature = 'scrape:backlinks {url : site url} {options : options list} {--pack= : pack id}';
    protected $description = 'scrape:backlinks example.com';
    
    public function exec()
    {
        
        $this->idPack = $this->option('pack');
        $this->options = explode('-', $this->argument('options'));
        
        $backlinks = [];
        foreach ($this->options as $option) { 
            $mode = 'exactDomain'; // 'domain' option
            if ($option == 'url') {
                $mode = 'exactUrl';
            } elseif ($option == 'subdomain') {
                $mode = 'domainWithSubdomains';
            }
            
            $webmeup = new WebMeUp('4fd7428f-bc7f-49f9-85bc-7282bfaс');
            $data = $webmeup->url($this->url)->mode($mode)->get();
            
            $urls = [];
            if (isset($data['backlinks'])) { 
                foreach ($data['backlinks'] as $url) {
                    $urls[] = $url['url'];
                }
            }
            $backlinks[$option] = array_filter($urls);
        }

        $parsers = $this->site->parsers;
        $parsers[$this->type] = [
            'data' => $backlinks,
            'updated_at' => time(),
        ];
        $this->site->parsers = $parsers;
        $this->site->save();
        
        
        $this->data = $backlinks;
    } // end exec
    
    protected function isApiRequestSuccessful()
    {
        return isset($this->data['urls']) && !empty($this->data['urls']);
    } // end isApiRequestSuccessful
    
}

