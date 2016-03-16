<?php

namespace Yaro\OAuth;

use Input;


class OAuth
{
    private $google = [];
    private $facebook = [];
    private $yahoo = [];
    

    public function google()
    {
        $token = Input::get('token');
        if (array_key_exists($token, $this->google)) {
            return $this->google[$token];
        }
        
        $url = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token='. $token;
        $this->google[$token] = collect(json_decode(file_get_contents($url), true));
        
        return $this->google[$token];
    } // end google
    
    public function facebook()
    {
        $token = Input::get('token');
        if (array_key_exists($token, $this->facebook)) {
            return $this->facebook[$token];
        }
        
        $fields = 'id,email,gender,link,locale,name,first_name,last_name,timezone,updated_time,verified';
        $url = 'https://graph.facebook.com/me?fields='. $fields .'&access_token='. $token;
        $this->facebook[$token] = collect(json_decode(file_get_contents($url), true));
        
        return $this->facebook[$token];
    } // end facebook
    
    public function yahoo()
    {
        // $token = Input::get('token');
        // if (array_key_exists($token, $this->yahoo)) {
            // return $this->yahoo[$token];
        // }
//         
        // $fields = 'id,email,gender,link,locale,name,first_name,last_name,timezone,updated_time,verified';
        // $url = 'https://graph.facebook.com/me?fields='. $fields .'&access_token='. $token;
        // $this->yahoo[$token] = collect(json_decode(file_get_contents($url), true));
//         
        // return $this->yahoo[$token];
    } // end yahoo
    
    
    public function amazon()
    {
        // verify that the access token belongs to us
        $c = curl_init('https://api.amazon.com/auth/o2/tokeninfo?access_token=' . urlencode($_REQUEST['access_token']));
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
         
        $r = curl_exec($c);
        curl_close($c);
        $d = json_decode($r);
         
        if ($d->aud != 'YOUR-CLIENT-ID') {
          // the access token does not belong to us
          header('HTTP/1.1 404 Not Found');
          echo 'Page not found';
          exit;
        }
         
        // exchange the access token for user profile
        $c = curl_init('https://api.amazon.com/user/profile');
        curl_setopt($c, CURLOPT_HTTPHEADER, array('Authorization: bearer ' . $_REQUEST['access_token']));
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
         
        $r = curl_exec($c);
        curl_close($c);
        $d = json_decode($r);
         
        echo sprintf('%s %s %s', $d->name, $d->email, $d->user_id);
    } // end amazon
    
    
    public function renderJs()
    {
        $script = '<script type="text/javascript" src="'. asset('/packages/yaro/oauth/oauth.js') .'"></script>';
        
        // Google
        $script .= '<script type="text/javascript">';
        $script .= 'oauth.google.CLIENTID = "'. config('yaro.oauth.google.client_id', '') .'";';
        $script .= 'oauth.google.SCOPE = "'. config('yaro.oauth.google.scope', '') .'";';
        $script .= '</script>';
        
        // Facebook
        $script .= '<script type="text/javascript">';
        $script .= 'oauth.facebook.CLIENTID = "'. config('yaro.oauth.facebook.client_id', '') .'";';
        $script .= 'oauth.facebook.SCOPE = "'. config('yaro.oauth.facebook.scope', '') .'";';
        $script .= '</script>';
        
        // Yahoo
        $script .= '<script type="text/javascript">';
        $script .= 'oauth.yahoo.CLIENTID = "'. config('yaro.oauth.yahoo.client_id', '') .'";';
        $script .= '</script>';
        
        
        return $script;
    } // end renderJs

}

