<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Url extends Eloquent
{
    
    protected $table = 'urls';
    protected $collection = 'urls';
    protected $connection = 'mongodb';
    public $timestamps = false;
    
    public function getContacts()
    {
        return json_decode($this->contacts) ?: [];
    } // end getContacts
    
    public function getValidParserInfo($parser)
    {
        $info = array_get($this->parsers, $parser, false);
        if (!$info || ($info['updated_at'] < strtotime('-2 month'))) {
            return false;
        }
        
        unset($info['updated_at']);
        
        return $info;
    } // end getValidParserInfo
    
}

