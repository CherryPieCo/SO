<?php

namespace App\Helpers;


class Alexa
{

    public static function popularity($url) 
    {
        $host = parse_url($url, PHP_URL_HOST);
        $xml = @file_get_contents('http://data.alexa.com/data?cli=10&url='. $host);
        
        preg_match('~POPULARITY.+TEXT="(\d+)"~', $xml, $matches);
        $rank = isset($matches[1]) ? $matches[1] : 0;
        
        return $rank;
    } // end popularity

}
