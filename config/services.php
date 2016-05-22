<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => 'simpleoutreach.com',
        'secret' => 'key-2f226c390fd875573db652bc252349f8',
    ],

    'mandrill' => [
        'secret' => '',
    ],

    'ses' => [
        'key'    => '',
        'secret' => '',
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => '',
        'secret' => '',
    ],
    
    
    'google' => [
        'client_id' => '1000709181512-gd7bdacahujm38hvhrviq91b993g6qfh.apps.googleusercontent.com',
        'client_secret' => 'BHa-nz1TVT0CcCGPK8UlD7OZ',
        'redirect' => 'http://wines.cherry-pie.co/_oauth/google/redirect',
    ],
    
    'yahoo' => [
        'client_id' => 'dj0yJmk9dXMwMk41NWFEOW9vJmQ9WVdrOVNVWndXR0o0TkdFbWNHbzlNQS0tJnM9Y29uc3VtZXJzZWNyZXQmeD01Ng--',
        'client_secret' => '28bba002e3ad66dd040a3b9acc65b7eb5470978d',
        'redirect' => 'http://wines.cherry-pie.co/_oauth/yahoo/redirect',
    ],

];
