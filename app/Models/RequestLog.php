<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Sentinel;


class RequestLog extends Eloquent
{
    
    protected $dates = ['logged_at'];
    
    protected $collection = 'logs';
    protected $connection = 'mongodb';
    
    public $timestamps = false;
    
    
    public function scopeByUser($query, $idUser = false)
    {
        $idUser = $idUser ?: Sentinel::getUser()->id;
        
        return $query->where('id_user', $idUser); // (int) 
    } // end byUser
    
    public function getUserMonthStatisticsByDate($idUser = false)
    {
        $idUser = $idUser ?: Sentinel::getUser()->id;
        
        return $this->raw(function($collection) use($idUser) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'logged_at' => [
                            '$gte' => \Carbon\Carbon::now()->subMonth(), 
                            '$lte' => \Carbon\Carbon::now(),
                        ],
                        'id_user' => $idUser,
                    ]
                ],
                [
                    '$group' => [
                        '_id' => '$logged_at',
                        'count' => [
                            '$sum' => 1
                        ]
                    ],
                ],
            ]);
        });
    } // end getUserMonthStatisticsByDate
    
}


