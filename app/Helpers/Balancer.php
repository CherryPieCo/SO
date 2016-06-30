<?php

namespace App\Helpers;

use DB;
use Bus;
use App\Jobs\CommandHandler;


class Balancer
{
    
    private static $queues = [
        'q00' => 0, 'q01' => 0, 'q02' => 0, 'q03' => 0, 'q04' => 0, 
        'q05' => 0, 'q06' => 0, 'q07' => 0, 'q08' => 0, 'q09' => 0, 
        //'q10' => 0, 'q11' => 0, 'q12' => 0, 'q13' => 0, 'q14' => 0, 
        // 'q15' => 0, 'q16' => 0, 'q17' => 0, 'q18' => 0, 'q19' => 0, 
        // 'q20' => 0, 'q21' => 0, 'q22' => 0, 'q23' => 0, 'q24' => 0, 
        // 'q25' => 0, 'q26' => 0, 'q27' => 0, 'q28' => 0, 'q29' => 0, 
        // 'q30' => 0, 'q31' => 0, 'q32' => 0, 'q33' => 0, 'q34' => 0, 
        // 'q35' => 0, 'q36' => 0, 'q37' => 0, 'q38' => 0, 'q39' => 0, 
        // 'q40' => 0, 'q41' => 0, 'q42' => 0, 'q43' => 0, 'q44' => 0, 
        // 'q45' => 0, 'q46' => 0, 'q47' => 0, 'q48' => 0, 'q49' => 0, 
        // 'q50' => 0, 'q51' => 0, 'q52' => 0, 'q53' => 0, 'q54' => 0, 
        // 'q55' => 0, 'q56' => 0, 'q57' => 0, 'q58' => 0, 'q59' => 0, 
    ];
    
    public static function queue($data, $parser, $url, $pack, $options)
    {
        $job = new CommandHandler($data, $parser, $url, $pack, $options);
        $job->onQueue(self::getLowestQueueName());
        
        Bus::dispatch($job);
    } // end queue
    
    public static function getLowestQueueName()
    {
        if (config('queue.default') != 'database') {
            return array_rand(self::$queues);
        }
        
        $queues = DB::table('jobs')
                    ->select('queue', DB::raw('COUNT(*) as count'))
                    ->groupBy('queue')
                    ->get();
        
        $allowed = self::$queues;
        foreach ($queues as $queue) {
            if (!array_key_exists($queue['queue'], $allowed)) {
                continue;
            }
            
            $allowed[$queue['queue']] = $queue['count'];
        }
        
        return array_keys($allowed, min($allowed))[0];
    } // end getLowestQueueName
    
}
