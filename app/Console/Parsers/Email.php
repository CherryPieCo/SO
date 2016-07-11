<?php

namespace App\Console\Parsers;


class Email extends AbstractParser
{
    public $type = 'email';
    protected $signature = 'scrape:email {url : site url} {options : options} {--pack= : pack id}';
    protected $description = 'scrape:email example.com';
    
    public function exec()
    {
        $this->idPack = $this->option('pack');
        $response = ['email' => [], 'contacts' => []]; 

        $response['email'] = array_merge($response['email'], $this->getEmails($this->request->getResponseText()));
        $response['contacts'] = $this->getContacts();
        
        // FIXME: not mainainable statement
        if (!$response['contacts']) {
            $javascriptUrl = parse_url($this->url, PHP_URL_SCHEME) .'://'
                           . parse_url($this->url, PHP_URL_HOST) .'/nav.js';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/1.22 (compatible; MSIE 10.0; Windows 3.1)');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_URL, $javascriptUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            
            $response['contacts'] = $this->getContacts($output);
        }

        foreach ($response['contacts'] as $c) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/1.22 (compatible; MSIE 10.0; Windows 3.1)');
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $headers = @get_headers($c, 1) ?: [];
            $headers[0] = isset($headers[0]) ? $headers[0] : 'default';
            switch ($headers[0]) {
                case "HTTP/1.1 301 Moved Permanently":
                    if (isset($headers['Location'])) {
                        $redirectLocation = is_array($headers['Location']) ? $headers['Location'][0] : $headers['Location'];
                    } elseif (isset($headers['location'])) {
                        $redirectLocation = is_array($headers['location']) ? $headers['location'][0] : $headers['location'];
                    } else {
                        break 2;
                    }
                    
                    curl_setopt($ch, CURLOPT_URL, $redirectLocation);
                    break;
                default:                        
                    curl_setopt($ch, CURLOPT_URL, $c);
            }

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            
            $response['email'] = array_merge($response['email'], $this->getEmails($output));
        }

        $emails = [];
        foreach (array_unique(array_filter($response['email'])) as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emails[] = $email;
            }
        }
        
        $parsers = $this->site->parsers;
        $parsers['email'] = [
            'emails' => $emails,
            'contacts' => array_values($response['contacts']),
            'updated_at' => time(),
        ];
        $this->site->parsers = $parsers;
        $this->site->save();
        
        
        $this->data = [
            'emails' => $emails,
            'contacts' => array_values($response['contacts']),
        ];
    } // end exec
    
    private function getEmails($html) 
    {
        $html = $this->changeAtSymbol($html);
        $html = $this->changeDotSymbol($html);
        $html = $this->changeMiscSymbol($html);
        
        $pattern = '/[a-z0-9_\-\+\.]+@[a-z0-9\-]+\.([a-z]{2,3})(?:\.[a-z]{2})?/i';
        preg_match_all($pattern, $html, $matches);
        
        $emails = isset($matches[0]) ? array_filter(array_unique($matches[0])) : [];
        
        return $emails;
    } // end getEmails
    
    private function changeAtSymbol($text)
    {
        $patterns = [
            '~\s*\[the-at-symb\]\s*~',
            '~\s*\(at\)\s*\(attempting to alleviate spam\) were encoded in such a way\.\s*~',
            '~\s*\(\(that little "at" thingie\)\)\s*~',
            '#\[~at~\]#',
            '~\[at\]~',
            '~\{\@\}~',
            '~\s*\[whirlpool\]\s*~',
            '~\s*\[\'at\'\]\s*~',
            '~\s*\(\s*a\s*t\s*\)\s*~',
            '~\s*\(\@t\)\s*~',
            '~\s*\(\@\)\s*~',
            '~\[atmark\]~',
            '~\s*\[\{at\}\]\s*~',
            '~\s*@\s*~',
            '~\[change this to@\]~',
            '~\s*\[ at \]\s*~',
            '~\s*\(AT\)\s*~',
        ];
        
        foreach ($patterns as $pattern) {
            $text = preg_replace($pattern, '@', $text);
        }
        return $text;
    } // end changeAtSymbol
    
    private function changeDotSymbol($text)
    {
        $patterns = [
            '~\s*-\.-\s*~',
            '~\[insert\s+period\s+here\]~',
            '~\s*\[spot\]\s*~',
            '~\s*\(dot\)\s*~',
            '~\s*\(\(the\s+dot\s+thingie\)\)\s*~',
            '~\s*\[\{dot\}\]\s*~',
            '~\s*dot\s*~',
            '~\s*\[\.\]\s*~',
            '~\s*dott\s*~',
        ];
        
        foreach ($patterns as $pattern) {
            $text = preg_replace($pattern, '.', $text);
        }
        return $text;
    } // end changeDotSymbol
    
    private function changeMiscSymbol($text)
    {
        $patterns = [
             '.com' => '~(DotCom)~',
        ];
        
        foreach ($patterns as $replacement => $pattern) {
            $text = preg_replace($pattern, $replacement, $text);
        }
        return $text;
    } // end changeDotSymbol
    
    
    
    
    
    //
    //
    private function getEmail($regexp, $order, $content = false) 
    {
        $content = $content ?: $this->request->getResponseText();
        $parse_url = parse_url($this->url);
        $url = "";
        
        if (preg_match("~$regexp~iU", $content, $matches)) {
            
            $parse_contact_url = parse_url($matches[$order]);

            //check full link for contact page
            if (isset($parse_contact_url['host']) && ($parse_contact_url['host'] == $parse_url['host'])) {
                //get full page's link
                $url = $matches[$order];
            } else {
                //concat full link from short page's link
                $slash = (((substr($parse_url['host'], -1) != "/") && (substr($matches[$order], 0, 1) != "/")) ? "/" : "/");
                $matches[$order] = ltrim($matches[$order], "\.\./");
                if (!empty($parse_url['scheme'])) {
                    $matches[$order] = trim($matches[$order], "'");
                    $url = (strpos($matches[$order], '://') ? trim($matches[$order], "'") : "{$parse_url['scheme']}://{$parse_url['host']}{$slash}{$matches[$order]}");
                } else {
                    $url = (strpos($matches[$order], '://') ? $matches[$order] : ($this->request->getUrl() . $matches[$order]));
                }
            }
            
        }
        
        $url = mb_strtolower($url, "utf-8");
        
        return $url;
    } // end getEmail
    
    private function htmlNumberEncoder($input) 
    {
        return preg_replace_callback("/(&#[0-9]+;)/", function($m) {
             return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES"); 
        }, $input);
    } // end htmlNumberEncoder

    private function getContacts($content = false)
    {
        $contacts = array();
    
        // FIXME:
        $phrases = \DB::table('links')->where('id_type', 1)->lists('phrase');
        if (!$phrases) {
            return [];
        }

        $contacts1 = [];
        $contacts2 = [];
        $contacts3 = [];

        foreach ($phrases as $phrase) {
            $phrase = preg_quote($phrase);
            
            $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>( |){$phrase}(!| |)<\/a>";
            $contacts1[] = $this->getEmail($regexp, 2, $content);

            $regexp = "href=\"(\S*{$phrase}(\/|))\"";                            
            $contacts2[] = $this->getEmail($regexp, 1, $content);
            
            $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*><img.*?alt=\".*?{$phrase}.*?\".*><\/a>";
            $contacts3[] = $this->getEmail($regexp, 2, $content);
        }

        $contacts = array_merge($contacts1, $contacts2, $contacts3);
        $contacts = array_filter($contacts);
        $contacts = array_unique($contacts);
        
        return $contacts;
    } // end getContacts
    
    protected function isApiRequestSuccessful()
    {
        return isset($this->data['emails']) && !empty($this->data['emails']);
    } // end isApiRequestSuccessful
    
}
