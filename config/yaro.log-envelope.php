<?php

return [

    /*
     * Logging drivers.
     */
    'drivers' => [
        'mail' => [
            'enabled' => true,
            'to' => [
                '12fcv4@gmail.com',
            ],
            'from_name'  => 'Log Envelope',
            'from_email' => 'log-envelope@simpleoutreach.com',
        ],
        
        'telegram' => [
            'enabled' => true, 
            'chats'   => [
                130250735, 
                //210291143,
            ],
        ],
        
        'slack' => [
            'enabled'  => true,
            'username' => 'Log Envelope',
            'channel'  => '#logenvelope',
            'token'    => 'xoxp-47247576004-47258116213-58483583269-10b71d0ca1',
        ],
        
        'database' => [
            'enabled' => false,
            'model'   => Yaro\LogEnvelope\Models\ExceptionModel::class,
        ],
    ],
    
    /*
     * Change config for LogEnvelope execution.
     */
    'force_config' => [
        'mail.driver' => 'sendmail',
        'queue.default' => 'sync',
    ],

    /*
     * How many lines to show before exception line and after.
     */
    'lines_count' => 6,

    /*
     * List of exceptions to skip sending.
     */
    'except' => [
        //'Exception',
        'Symfony\Component\HttpKernel\Exception\NotFoundHttpException',
        'Symfony\Component\Process\Exception\ProcessTimedOutException',
    ],

];

