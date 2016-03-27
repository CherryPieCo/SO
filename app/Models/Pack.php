<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Pack extends Eloquent
{
    
    //protected $table = 'packs';
    protected $collection = 'packs';
    protected $connection = 'mongodb';
    
    public $timestamps = false;
    
    
    public function getData()
    {
        return $this->data;
    } // end getData
    
    public function isComplete()
    {
        return $this->status == 'complete';
    } // end isComplete
    
}


