<?php

namespace App\Http\Controllers;

use Input;
use Sentinel;
use Artisan;
use App\User;
use App\Models\Url;
use App\Models\Pack;
use Illuminate\Http\Response;


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
        $error = '';
        if (!$this->user->isCampaignAllowed('emails', $error, true)) {
            $content = json_encode(compact('error'));
            return (new Response($content, 403))->header('Content-Type', 'application/json');
        }
        
        
        $url = urldecode($url);
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
        
        $domain = parse_url($site->url, PHP_URL_SCHEME) .'://'. parse_url($site->url, PHP_URL_HOST);
        $parsers = $site->parsers;
        $data = [
            'domain' => $domain,
            'url' => $site->url,
            'emails' => array_get($parsers, 'email.emails', []),
            'contacts' => array_get($parsers, 'email.contacts', []),
        ];
        
        return response()->json(compact('data'));
    } // end email
    
    
}