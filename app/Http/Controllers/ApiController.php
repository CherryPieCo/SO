<?php

namespace App\Http\Controllers;

use Input;
use Sentinel;
use Artisan;
use App\User;
use App\Models\Url;
use App\Models\Pack;


class ApiController extends Controller
{
    
    private $user;
    
    public function __construct()
    {
        $idUser = User::where('token', Input::get('token'))->pluck('id');
        
        $this->user = Sentinel::findById($idUser);
    } // end __construct
    
    public function me()
    {
        $data = [
            'first_name' => $this->user->first_name,
            'last_name'  => $this->user->last_name,
            'email'      => $this->user->email,
        ];
        return response()->json(compact('data'));
    } // end me
    
    public function email($url)
    {
        $url = urldecode(Input::get('url'));
        
        if (!parse_url($url, PHP_URL_SCHEME)) {
            $url = 'http://'. $url;
        }
        
        // FIXME: reparse if time
        $site = Url::where('hash', md5($url))->first();
        if (!$site) {
            Artisan::call('scrape:email', [
                'url' => $url
            ]);
            
            $site = Url::where('hash', md5($url))->first();
        }
        $parsers = $site->parsers;
        $data = [
            'url' => $site->url,
            'emails' => array_get($parsers, 'email.emails', []),
            'contacts' => array_get($parsers, 'email.contacts', []),
        ];
        
        return response()->json(compact('data'));
    } // end email
    
}