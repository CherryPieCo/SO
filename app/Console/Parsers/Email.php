<?php

namespace App\Console\Parsers;

use App\Helpers\TLD;


class Email extends AbstractParser
{
    public $type = 'email';
    protected $signature = 'scrape:email {url : site url} {options : options} {--pack= : pack id}';
    protected $description = 'scrape:email example.com';
    
    private $social = [];
    
    
    public function exec()
    {
        $this->idPack = $this->option('pack');
        $response = ['email' => [], 'contacts' => []]; 

        //$response['email'] = array_merge($response['email'], $this->getEmails($this->request->getResponseText()));
        $response['contacts'] = $this->getContacts();
        $this->grabSocialProfiles();

        // urls in js
        // FIXME: not mainainable statement
        if (!$response['contacts']) {
            
            $jsUrls = [
                'nav.js',
            ];
            foreach ($jsUrls as $jsUrl) {
                $javascriptUrl = parse_url($this->url, PHP_URL_SCHEME) .'://'
                               . parse_url($this->url, PHP_URL_HOST) .'/'. $jsUrl;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_USERAGENT, AbstractParser::USER_AGENT);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_URL, $javascriptUrl);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $output = curl_exec($ch);
                
                $response['contacts'] = array_merge($response['contacts'], $this->getContacts($output));
                $this->grabSocialProfiles($output);
            }
        }

        foreach ($response['contacts'] as $c) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_USERAGENT, AbstractParser::USER_AGENT);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

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
            $this->grabSocialProfiles($output);
        }
        // dr($this->request->getResponseText());
        //dr($response);
        $emails = [];
        foreach ($response['email'] as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emails[] = mb_strtolower($email);
            }
        }
        
        $emails = array_unique(array_filter($emails));
        
        $emails = $this->filterSpamCatcherEmails($emails);
        $emails = $this->revealSpamCatcherEmails($emails);
        $emails = $this->checkForRealEmails($emails);
        
        $social = [];
        foreach ($this->social as $socialType => $socialData) {
            $social[$socialType] = array_filter(array_unique($socialData));
        }
        
        
        $parsers = $this->site->parsers;
        $parsers['email'] = [
            'emails' => $emails,
            'contacts' => array_values($response['contacts']),
            'social' => $social,
            'updated_at' => time(),
        ];
        $this->site->parsers = $parsers;
        $this->site->save();
        
        
        $this->data = [
            'emails' => $emails,
            'contacts' => array_values($response['contacts']),
            'social' => $social,
        ];
    } // end exec
    
    private function checkForRealEmails($emails)
    {
        foreach ($emails as $key => $email) {
            if (!TLD::check($email)) {
                unset($emails[$key]);
            }
        }
        
        return $emails;
    } // end checkForRealEmails
    
    private function filterSpamCatcherEmails($emails)
    {
        $domains = [
            'nospam.',
            'example.com',
            'domain.com',
            'yoursite.com',
            'yourdomain.com',
            'emailadress.com',
            'company.com',
            'yourdomain.com',
        ];
        
        foreach ($emails as $key => $email) {
            foreach ($domains as $domain) {
                $pattern = '~@'. preg_quote($domain) .'~';
                if (preg_match($pattern, $email)) {
                    unset($emails[$key]);
                    break;
                }
            }
        }
        
        return $emails;
    } // end filterSpamCatcherEmails
    
    private function revealSpamCatcherEmails($emails)
    {
        $replacements = [
            '@googlemail.com' => '@gmail.com',
        ];
        
        foreach ($emails as &$email) {
            foreach ($replacements as $from => $to) {
                $pattern = '~'. preg_quote($from) .'~';
                $email = preg_replace($pattern, $to, $email);
            }
        }
        
        return $emails;
    } // end revealSpamCatcherEmails
    
    private function getEmails($html) 
    {
        $html = $this->changeAtSymbol($html);
        $html = $this->changeDotSymbol($html);
        $html = $this->changeMiscSymbol($html);
        //$html = $this->customReplaces($html);
        $html = html_entity_decode($html);
        
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
            //'~\sat\s~',
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
            '~\s*{\s*at\s*}\s*~',
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
             '@gmail.com' => '~ at gmail dot com~',
             '@gmail.com' => '~ at gmail\.com~',
        ];
        
        foreach ($patterns as $replacement => $pattern) {
            $text = preg_replace($pattern, $replacement, $text);
        }
        return $text;
    } // end changeDotSymbol
    
    private function customReplaces($text)
    {
        $text = preg_replace_callback(
            '~[^\w]{1}([a-zA-Z0-9_\.-]+) at ([a-zA-Z0-9_-]+\.[a-zA-Z0-9_-]{2,6})[^\w]{1}~',
            function ($matches) {
                if (isset($matches[1]) && isset($matches[2])) {
                    return ' '. $matches[1] .'@'. $matches[2] .' ';
                }
                return $matches[0];
            },
            $text
        );
        
        return $text;
    } // end customReplaces
    
    private function getEmail($regexp, $order, $content = false) 
    {
        $content = $content ?: $this->request->getResponseText();
        
        $parse_url = parse_url($this->url);
        $url = "";
        
        if (preg_match("~$regexp~iU", $content, $matches)) {
            $parse_contact_url = parse_url($matches[$order]);

            //check full link for contact page
            if (isset($parse_contact_url['host'])) {
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
            
            $parse_contact_url = parse_url($url);
            // possible contact page is not from this site
            if (isset($parse_contact_url['host']) && strpos(mb_strtolower($parse_contact_url['host']), mb_strtolower($parse_url['host'])) === false) {
                return '';
            }
        }
        
        $url = mb_strtolower($url, "utf-8");
        
        
        return $url;
    } // end getEmail
    
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
        $contacts4 = [];
        $contacts5 = [];
        $contacts6 = [];

        foreach ($phrases as $phrase) {
            $phrase = preg_quote($phrase);
            
            $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*>( |){$phrase}(!| |)<\/a>";
            $contactUrl = $this->getEmail($regexp, 2, $content);
            if (!preg_match('~mailto:~', $contactUrl)) {
                $contacts1[] = $contactUrl;
            }

            $regexp = "href=\"(\S*{$phrase}(\/|))\"";                            
            $contacts2[] = $this->getEmail($regexp, 1, $content);
            
            $regexp = "<a\s[^>]*href=(\"??)([^\" >]*?)\\1[^>]*><img.*?alt=\".*?{$phrase}.*?\".*><\/a>";
            $contacts3[] = $this->getEmail($regexp, 2, $content);
            
            
            //
            $regexp = "<a\s[^>]*href=('??)([^' >]*?)\\1[^>]*>( |){$phrase}(!| |)<\/a>";
            $contactUrl = $this->getEmail($regexp, 2, $content);
            if (!preg_match('~mailto:~', $contactUrl)) {
                $contacts4[] = $contactUrl;
            }

            $regexp = "href='(\S*{$phrase}(\/|))'";                            
            $contacts5[] = $this->getEmail($regexp, 1, $content);
            
            $regexp = "<a\s[^>]*href=('??)([^' >]*?)\\1[^>]*><img.*?alt='.*?{$phrase}.*?'.*><\/a>";
            $contacts6[] = $this->getEmail($regexp, 2, $content);
        }

        $contacts = array_merge($contacts1, $contacts2, $contacts3, $contacts4, $contacts5, $contacts6);
        $contacts = array_filter($contacts);
        $contacts = array_unique($contacts);
        $contacts = array_map(function($value) {
            return trim(trim($value, "'"), '"');
        }, $contacts);
        
        return $contacts;
    } // end getContacts
    
    // legacy fuck
    private function grabSocialProfiles($content = false)
    {
        $content = $content ?: $this->request->getResponseText();
        
        $fb_except = array(
            "likebox.php",
            "like.php",
            "tr",
            "sharer.php",
            "share.php",
            "photo.php",
            "fbml",
            "",
            "home.php",
            "oneupweb",
            "Mode",
            "permalink.php",
            "facepile.php",
            "debug",
            "plugins",
            "feed",
            "oauth",
            "v2.2",
            "fbconnect",
            "api_lib",
            "timeline",
            "application.php",
            "group.php",
            "video.php"
        );
        $in_except = array(
            "share",
            "shareArticle?",
            "groups?"
        );
        $pn_except = array(
            "/pin/create/",
            "/pin/find/"
        );
        $tw_except = array(
            "twitter.com/share",
            "twitter.com/home",
            "twitter.com/login",
            "twitter.com/about",
            "twitter.com/intent",
            "twitter.com/search"
        );
        $gp_except = array(
            "share",
            "/u/0/"
        );
        
        if (preg_match_all('/(?:(?:http|https):\/\/)?(?:www.)?facebook.com\/(?:(?:\w)*#!\/)?(?:pages\/)?(?:[?\w\-]*\/)?(?:profile.php\?id=(?=\d.*))?([\w\.\-]*)?/', $content, $matches)) {
            if (count($matches[1])) {
                foreach($matches[1] as $k => $v) {
                    if (in_array($v, $fb_except) === false) {
                        $this->social['facebook'][] = $matches[0][$k];
                        break;
                    }
                }
            }
        }
        
        if (preg_match_all('|https?://(?:www\.)?pinterest.com/[a-z0-9_/-]+|im', $content, $matches)) {
            if (count($matches)) {
                foreach($matches as $mm) {
                    foreach($mm as $m) {
                        if ($this->strpos_array($m, $pn_except, 1) === false) {
                            $this->social['pinterest'][] = $m;
                            break;
                        }
                    }
                }
            }
        }
        
        if (preg_match_all('|https?://(?:www\.)?twitter.com/[a-z0-9_]+|im', $content, $matches)) {
            if (count($matches)) {
                foreach($matches as $mm) {
                    foreach($mm as $m) {
                        if ($this->strpos_array($m, $tw_except, 1) === false) {
                            $this->social['twitter'][] = $m;
                            break;
                        }
                    }
                }
            }
        }
        
        if (preg_match_all('|https?://(?:www\.)?linkedin.com/[a-z0-9_/-?=\-]+|im', $content, $matches)) {
            if (count($matches)) {
                foreach($matches as $mm) {
                    foreach($mm as $m) {
                        if ($this->strpos_array($m, $in_except, 1) === false) {
                            $this->social['linkedin'][] = $m;
                            break;
                        }
                    }
                }
            }
        }
        
        if (preg_match_all('|https?://(?:www\.)?plus.google.com/[a-z0-9_/-?=]+|im', $content, $matches)) {
            if (count($matches)) {
                foreach($matches as $mm) {
                    foreach($mm as $m) {
                        if ($this->strpos_array($m, $gp_except, 1) === false) {
                            $this->social['gplus'][] = $m;
                            break;
                        }
                    }
                }
            }
        }
    } // end grabSocialProfiles
    
    // legacy fuck
    private function strpos_array($haystack, $needles = [], $offset = 0) 
    {
        $chr = array();
        foreach($needles as $needle) {
            $res = strpos($haystack, $needle, $offset);
            if ($res !== false) $chr[$needle] = $res;
        }
        if(empty($chr)) return false;
        
        return min($chr);
    } // end strpos_array
    
    
    protected function isApiRequestSuccessful()
    {
        return isset($this->data['emails']) && !empty($this->data['emails']);
    } // end isApiRequestSuccessful
    
}
