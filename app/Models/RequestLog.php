<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Carbon\Carbon;
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
        
        $requestDates = $this->raw(function($collection) use($idUser) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'logged_at' => [
                            '$gte' => Carbon::now()->subMonth(), 
                            '$lte' => Carbon::now(),
                        ],
                        'id_user' => $idUser,
                    ]
                ],
                [
                    '$group' => [
                        '_id' => '$logged_at',
                        'cnt' => [
                            '$sum' => 1
                        ]
                    ],
                ],
            ]);
        });
        
        
        $requestDatesNew = [];
        foreach ($requestDates as $requestDate) {
            $requestCarbon = new Carbon($requestDate->_id->date, $requestDate->_id->timezone);
            $requestDateKey = $requestCarbon->day .'/'. $requestCarbon->month;
            $requestDatesNew[$requestDateKey] = $requestDate->cnt;
        }
        
        $nowDateString = Carbon::now()->addDay()->toDateString();
        $carbon = Carbon::now()->subMonth();
        
        $dates = [];
        while ($carbon->toDateString() != $nowDateString) {
            $carbon->addDay();
            $date = $carbon->day .'/'. $carbon->month;
            
            $dates[$date] = 0;
            foreach ($requestDatesNew as $requestDateKey => $requestDateCount) {
                if ($date == $requestDateKey) {
                    $dates[$date] = $requestDateCount;
                    break;
                }
            }
        }

        return $dates;
    } // end getUserMonthStatisticsByDate
    
}


