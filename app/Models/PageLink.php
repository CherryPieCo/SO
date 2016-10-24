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
        // HACK:
        switch ($type) {
            case 'contact':
                return 1;
            case 'advertising':
                return 2;
            case 'useful':
                return 3;
            case 'donate':
                return 4;
            case 'blog':
                return 5;
            case 'guest':
                return 6;
            
            default:
                throw new \RuntimeException(sprintf('Unknown page type: [%s]', $type));
        }
        
        //return \DB::table('links_types')->where('type', $type)->pluck('id');
    } // end 
    
}


