<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Carbon\Carbon;
use Sentinel;


class RequestLog extends Eloquent
{
    
    //protected $dates = ['logged_at'];
    
    protected $collection = 'logs';
    protected $connection = 'mongodb';
    
    public $timestamps = false;
    
    
    public function scopeByUser($query, $idUser = false)
    {
        $idUser = $idUser ?: Sentinel::getUser()->id;
        
        return $query->where('id_user', $idUser); 
    } // end byUser
    
    public function scopeInMonth($query)
    {
        return $query->whereBetween('logged_at', [Carbon::now()->subMonth(), Carbon::now()]); 
    } // end inMonth
    
    public static function getUserMonthStatisticsByDate($idUser = false)
    {
        $stats = [];
        
        $nowDateString = Carbon::now()->toDateString();//->addDay()
        $carbon = Carbon::now()->subMonth()->subDay();
        
        while ($carbon->toDateString() != $nowDateString) {
            $carbon->addDay();
            $dateKey = $carbon->day .'/'. $carbon->month;
            
            $stats[$dateKey] = 0;
        }
        
        $dates = RequestLog::byUser()->inMonth()->get();
        foreach ($dates as $date) {
            $date->logged_at = new Carbon($date->logged_at['date'], $date->logged_at['timezone']);
            $dateKey = $date->logged_at->day .'/'. $date->logged_at->month;
            
            ++$stats[$dateKey];
        }
    
        
        return $stats;
    } // end getUserMonthStatisticsByDate
    
}


