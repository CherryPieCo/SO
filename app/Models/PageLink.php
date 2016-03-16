<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageLink extends Model
{
    
    protected $table = 'links';
    public $timestamps = false;
    
    public function scopeType($query, $type)
    {
        return $query->where('id_type', self::getTypeID($type));
    } // end 
    
    public static function getTypeID($type)
    {
        return \DB::table('links_types')->where('type', $type)->pluck('id');
    } // end 
    
}


