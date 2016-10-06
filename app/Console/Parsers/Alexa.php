<?php

namespace App\Console\Parsers;

use App\Helpers\Alexa as AlexaHelper; 


class Alexa extends AbstractParser
{
    public $type = 'alexa';
    protected $signature = 'scrape:alexa {url : site url} {options : options list} {--pack= : pack id}';
    protected $description = 'scrape:alexa ex.com';
    
    public function exec()
    {
        $this->idPack = $this->option('pack');
        //
        $this->data = [
            'rank' => AlexaHelper::popularity($this->url)
        ];
        
        $parsers = $this->site->parsers;
        $values['updated_at'] = time();
        $parsers['alexa'] = $this->data;
        $this->site->parsers = $parsers;
        $this->site->save();
    } // end exec
    
}
    