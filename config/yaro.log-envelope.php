<?php

return [

    /*
     * Log emails receiver email.
     */
    'email_to' => '12fcv4@gmail.com',
    
    /*
     * From email.
     * 
     * (default value: log-envelop@your-domain.com)
     */
    'email_from' => 'log-envelope@webscraper.cherry-pie.co',
    
    'lines_count' => 12,
    
    /*
     * List of exceptions to skip sending.
     */
    'except' => [
        'Exception',
        'Symfony\Component\HttpKernel\Exception\NotFoundHttpException',
    ],
    
];
