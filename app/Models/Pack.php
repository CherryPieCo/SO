<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pack extends Model
{
    
    protected $table = 'packs';
    public $timestamps = false;
    
    public function getData()
    {
        return json_decode($this->data, true);
    } // end getData
    
}


