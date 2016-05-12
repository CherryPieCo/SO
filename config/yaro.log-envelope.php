<?php

return [

    /*
     * Log emails receiver email.
     */
    'email_to' => '12fcv4@gmail.com',
    
    'log_to' => [
        'mail',
        'telegram',
        //'database',
    ],
    'should_queue' => false,
    'force_config' => [
        'mail.driver' => 'sendmail',
    ],
    
    /*
     * From email.
     * 
     * (default value: log-envelop@your-domain.com)
     */
    'email_from' => 'log-envelope@www.simpleoutreach.com',
    
    'lines_count' => 12,
    
    /*
     * List of exceptions to skip sending.
     */
    'except' => [
        //'Exception',
        'Symfony\Component\HttpKernel\Exception\NotFoundHttpException',
    ],
    
];
