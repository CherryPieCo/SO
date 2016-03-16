<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    
    protected $table = 'urls';
    public $timestamps = false;
    
    public function getContacts()
    {
        return json_decode($this->contacts) ?: [];
    } // end getContacts
    
}


